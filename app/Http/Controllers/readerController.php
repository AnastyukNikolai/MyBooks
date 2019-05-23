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

        $chapters = Chapter::withCount('purchases')->orderBy('purchases_count', 'desc')->get();

        dump($chapters);

    }

    public function cancelSponsorship($id) {

        $anons = Chapter::find($id);
        $anons_operations = $anons->financial_operations->where('type_id', 2)->where('status_id', 3);

        FinancialController::cancellationSponsorship($anons_operations);

        $anons->purchases()->where('user_id', Auth::user()->id)->delete();


        return redirect()->back()->with('success', 'Спонсирование успешно отменено, деньги возвращены');

    }


}
