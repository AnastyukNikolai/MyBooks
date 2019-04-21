<?php

namespace App\Http\Controllers;
use App\Artwork;
use App\Events\onAddArtworkEvent;
use App\Genre;
use App\Image;
use App\Language;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Requests\AddArtworkRequest;
use App\Http\Requests\AddChapterRequest;

use App\Http\Requests;

class authorController extends Controller
{

    public function artworksShow($id) {

        $user=User::find($id);
        $artworks=$user->artworks->where('transfer', false);
       // $image_link= \Storage::disk('public')->

        return view('authorBooks')->with(['artworks' => $artworks,
                                                'user' => $user,
                                                ]);

    }

    public function addArtwork() {

        $languages=Language::all();
        $genres = Genre::all();
        $user=Auth::user();

        return view('addArtwork')->with(['languages' => $languages,
                                               'genres' => $genres,
                                               'user' => $user,
                                                 ]);

    }

    public function storeArtwork(AddArtworkRequest $request) {

        //dump($request['genres']);
        $image_path=$request->file('image')->storePublicly('public/books_img');
        $image_path=preg_replace( "#public/#", "", $image_path );
        $image = Image::create([
            'img_link' => $image_path,
            'category_id' => 1,
        ]);
        event(new onAddArtworkEvent($request,$image));



    }

    public function addChapter($id) {

        $artwork_id = $id;

        return view('addChapter')->with([
            'artwork_id' => $artwork_id,
        ]);

    }

    public function storeChapter(AddChapterRequest $request) {

        //dump($request['genres']);
        $image_path=$request->file('image')->storePublicly('public/books_img');
        $image_path=preg_replace( "#public/#", "", $image_path );
        $image = Image::create([
            'img_link' => $image_path,
            'category_id' => 1,
        ]);
        event(new onAddArtworkEvent($request,$image));



    }
}
