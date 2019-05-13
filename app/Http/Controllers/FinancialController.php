<?php

namespace App\Http\Controllers;

use App\Buying_a_chapter;
use App\Events\onAddFinancialOperationEvent;
use App\Http\Requests\ChapterSponsorshipRequest;
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


        if($payment == true&&$operation->type_id == 1) {
            $operation->update([
                'status_id' => 1
            ]);

            return $operation->id;
        }

        elseif($payment == true&&$operation->type_id == 2) {

            return $operation->id;
        }

        else {

            $operation->update([
                'status_id' => 4
            ]);

            $error = 'При оплате произошла ошибка';

            return redirect()->back()->with(['error' => $error]);
        }

    }

    public function chapterSponsorship(ChapterSponsorshipRequest $request) {

        $anons = Chapter::find($request->anons_id);
        $min_amount = $anons->min_amount;
        $sponsor_sum = $request->sponsor_sum;

        if($min_amount > $sponsor_sum) {

            $error = 'Вы ввели сумму, которая ниже минимальной для спонсирования данного анонса';

            return redirect()->back()->with(['error' => $error]);
        }

        else {

            $buying = $this->financialOperation($sponsor_sum, 2, $request->user_id, $request->author_id);

            Buying_a_chapter::create([
                'chapter_id' => $anons->id,
                'financial_operation_id' => $buying,
                'user_id' => $request->user_id,
            ]);

            return redirect()->back()->with('success', 'Глава успешно спонсирована');
        }

    }

    public function chapterBuy($id) {

        $chapter = Chapter::find($id);
        $user = User::find(Auth::user()->id);
        $chapter_author = $chapter->artwork->user;

        $buying = $this->financialOperation($chapter->price, 1, $user->id, $chapter_author->id);

            Buying_a_chapter::create([
                'chapter_id' => $chapter->id,
                'financial_operation_id' => $buying,
                'user_id' => $user->id,
            ]);

        return redirect()->back()->with('success', 'Глава успешно куплена');

    }
}

