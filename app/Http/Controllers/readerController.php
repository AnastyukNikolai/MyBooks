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

    public function chapterBuy($id) {

        $chapter = Chapter::find($id);
        $user = Auth::user();
        $user_new_balance=$user->balance-$chapter->price;
        $chapter_author = $chapter->artwork->user;
        $chapter_author_new_balance=$chapter_author->balance+$chapter->price;

        User::find($user->id)->update([
            'balance' => $user_new_balance,
        ]);

        User::find($chapter_author->id)->update([
           'balance' =>  $chapter_author_new_balance,
        ]);

    }
}
