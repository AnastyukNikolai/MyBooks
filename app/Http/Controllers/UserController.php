<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function likedShow($id) {

        $user=User::find($id);
        $artworks=$user->liked;
        $message1='Понравившееся';
        $message2='Понравившееся пользователя';
        $n=false;

        return view('artwork.userBooks')
            ->with([
                'artworks' => $artworks,
                'user' => $user,
                'message1' => $message1,
                'message2' => $message2,
                'n' => $n,
            ]);

    }
}
