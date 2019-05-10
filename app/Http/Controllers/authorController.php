<?php

namespace App\Http\Controllers;
use App\Artwork;
use App\Chapter;
use App\Events\onAddArtworkEvent;
use App\Genre;
use App\Image;
use App\Language;
use Illuminate\Support\Facades\Auth;
use App\User;
use Google_Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Requests\AddArtworkRequest;
use App\Http\Requests\AddChapterRequest;
use App\Http\Controllers\DriveController;

use App\Http\Requests;

class authorController extends Controller
{

    public function artworksShow($id) {

        $author=User::find($id);
        $artworks=$author->artworks->where('transfer', false);
       // $image_link= \Storage::disk('public')->

        return view('artwork.authorBooks')->with(['artworks' => $artworks,
                                                'author' => $author,
                                                ]);

    }

    public function addArtwork() {

        $languages=Language::all();
        $genres = Genre::all();
        $user=Auth::user();

        return view('artwork.addArtwork')->with(['languages' => $languages,
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

        return redirect()->back()->with('success', 'Книга успешно добавлена');



    }

    public function addArtworkChapter($id) {

        $artwork_id = $id;

        return view('chapter.addChapter')->with([
            'artwork_id' => $artwork_id,
        ]);

    }

    public function storeArtworkChapter(AddChapterRequest $request) {

        $client = new Google_Client();
        dump($client);
        $artwork=Artwork::find($request->artwork_id);
        $number=$artwork->chapters->max('number')+1;
       // $text_store=$request->file('text')->storePublicly('public/books_chapter');
        $text_store = new DriveController($client);
        $text_store->uploadFile($request);
        //$text_path=preg_replace( "#public/#", "", $text_store );

        $chapter = Chapter::create([
            'id' => $text_store,
            'title' => $request->title,
            'text_link' => 'dfghj',
            'price' => $request->price,
            'artwork_id' => $request->artwork_id,
            'number' => $number,

        ]);

        return redirect()->back()->with('success', 'Глава успешно добавлена');

    }

    public function editArtworkChapter($id) {

        $chapter = Chapter::find($id);

        return view('chapter.editChapter')->with([
            'chapter' => $chapter,
        ]);

    }
}
