<?php

namespace App\Http\Controllers;

use App\Buying_a_chapter;
use App\Events\onAddFinancialOperationEvent;
use App\Http\Requests\ChapterSponsorshipRequest;
use App\Message;
use Illuminate\Support\Facades\Auth;
use App\Financial_operation;
use App\Chapter;
use App\User;
use Illuminate\Http\Request;

class FinancialController extends Controller
{

    public static function financialOperation($amount, $type_id, $payer_id, $receiver_id) {

        $operation = Financial_operation::create([
            'amount' => $amount,
            'type_id' => $type_id,
            'payer_id' => $payer_id,
            'receiver_id' => $receiver_id,
            'status_id' => 3
        ]);

        $payment = event(new onAddFinancialOperationEvent($operation));


        if($payment == true&&$operation->type_id == 1||$payment == true&&$operation->type_id == 4 ||$payment == true&&$operation->type_id == 5) {
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

            $error = 'При выполнении финансовой операции произошла ошибка';

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

        elseif ($request->sponsor_sum > Auth::user()->balance - Auth::user()->sale_transactions->where('status_id', 3)->sum('amount')) {

            $error = 'сумма спонсирования введенная вами превышает ваши наличные средства';

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

    public static function cancellationSponsorship($operations, $reader = null) {

        foreach ($operations as $operation) {

            $operation->update([
                'status_id' => 2,
            ]);


            $fin_controller = new FinancialController();
            $refund = $fin_controller->financialOperation($operation->amount, 4, $operation->receiver_id, $operation->payer_id);

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

    public function updateBalance (Request $request) {

        $user = User::find($request->user_id);
        $message = Message::find($request->message_id);

        $this->financialOperation($request->sum, 5, $user->id, $user->id);
        $message->delete();


        return redirect()->route('messagesIndex', ['id' => Auth::id(), 'type'=>4])->with('success', 'Баланс пользователя обновлен');
    }



}

