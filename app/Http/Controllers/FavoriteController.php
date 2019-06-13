<?php

namespace App\Http\Controllers;

use App\Artwork;
use App\Favorite;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function show($id) {

        $user=User::find($id);
        $artworks=$user->favorites;
        $message1='Избранное';
        $message2='Избранное пользователя';
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

    public function add($artwork_id, $user_id) {


        if($user_id==Auth::id()) {
            $message = 'Книга успешно добавлена в избранное';

            Favorite::create([
                'user_id' => $user_id,
                'artwork_id' => $artwork_id,
            ]);

            return redirect()->back()->with('success', $message);
        }

    }



    public function delete($artwork_id, $user_id) {

        $message='Книга успешно удалена из избранного';
        $favorite = Favorite::where('artwork_id', $artwork_id)->where('user_id', $user_id);

        $favorite->forceDelete();

        return redirect()->back()->with('success', $message);
    }


}
