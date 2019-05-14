<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Chapter;
use App\User;

class readerController extends Controller
{

    public function chapterSponsorship() {

    }

    public function test() {

        $chapter = Chapter::find(11);

        dump($chapter->financial_operations);

    }

    public function cancelSponsorship($id) {

        $anons = Chapter::find($id);
        $anons_operations = $anons->financial_operations->where('type_id', 2)->where('status_id', 3);

        FinancialController::cancellationSponsorship($anons_operations);

        $anons->purchases()->where('user_id', Auth::user()->id)->delete();


        return redirect()->back()->with('success', 'Спонсирование успешно отменено, деньги возвращены');

    }


}
