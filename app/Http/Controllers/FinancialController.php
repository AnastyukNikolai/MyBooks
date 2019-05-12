<?php

namespace App\Http\Controllers;

use App\Buying_a_chapter;
use App\Events\onAddFinancialOperationEvent;
use Illuminate\Support\Facades\Auth;
use App\Financial_operation;
use App\Chapter;
use App\User;
use Illuminate\Http\Request;

class FinancialController extends Controller
{

    public function financialOperation($amount, $type_id, $payer_id, $receiver_id) {

        $operation = Financial_operation::create([
            'amount' => $amount,
            'type_id' => $type_id,
            'payer_id' => $payer_id,
            'receiver_id' => $receiver_id,
            'status_id' => 3
        ]);

        $payment = event(new onAddFinancialOperationEvent($operation));


        if($payment == true) {
            $operation->update([
                'status_id' => 1
            ]);

            return $operation->id;
        }

        else {

            $operation->update([
                'status_id' => 4
            ]);

            return redirect()->back()->with('error', 'При оплате произошла ошибка');
        }

    }

    public function chapterSponsorship() {

    }

    public function chapterBuy($id) {

        $chapter = Chapter::find($id);
        $user = Auth::user();
        $chapter_author = $chapter->artwork->user;

        $buying = $this->financialOperation($chapter->price, 1, $user->id, $chapter_author->id);

            Buying_a_chapter::create([
                'chapter_id' => $chapter->id,
                'financial_operation_id' => $buying
            ]);

        return redirect()->back()->with('success', 'Глава успешно куплена');

    }
}

