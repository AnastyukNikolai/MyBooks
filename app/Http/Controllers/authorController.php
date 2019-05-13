<?php

namespace App\Http\Controllers;
use App\Artwork;
use App\Chapter;
use App\Events\onAddArtworkEvent;
use App\Genre;
use App\Category;
use App\Image;
use App\Language;
use App\Work_status;
use Illuminate\Support\Facades\Auth;
use App\User;
use Google_Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Requests\AddArtworkRequest;
use App\Http\Requests\AddChapterRequest;
use App\Http\Requests\PublishAnonsRequest;
use App\Http\Requests\AddAnonsRequest;
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
        $categories = Category::all();
        $statuses = Work_status::all();
        $user=Auth::user();

        return view('artwork.addArtwork')->with(['languages' => $languages,
                                               'genres' => $genres,
                                               'categories' => $categories,
                                               'user' => $user,
                                               'statuses' => $statuses,
                                                 ]);

    }

    public function storeArtwork(AddArtworkRequest $request) {

        $image_path=$request->file('image')->storePublicly('public/books_img');
        $image_path=preg_replace( "#public/#", "", $image_path );

        $image = Image::create([
            'image_path' => $image_path,
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

    public function addChapterAnons($id) {

        $artwork_id = $id;

        return view('chapter.addChapterAnons')->with([
            'artwork_id' => $artwork_id,
        ]);

    }

    public function storeChapterAnons(AddAnonsRequest $request) {

        $artwork=Artwork::find($request->artwork_id);
        $number=$artwork->chapters->max('number')+1;
        if($request->min_amount==null) {
            $request->min_amount=0;
        }

        $chapter = Chapter::create([

            'announcement' => true,
            'title' => $request->title,
            'artwork_id' => $request->artwork_id,
            'min_amount' => $request->min_amount,
            'description' => $request->description,
            'price' => 0,

        ]);

        return redirect()->back()->with('success', 'Анонс успешно добавлен');

    }


    public function cancelAnnouncement($id) {

        $chapter = Chapter::find($id);


        return redirect()->back()->with('success', 'Анонс успешно отменен');

    }

    public function editArtworkChapter($id) {

        $chapter = Chapter::find($id);

        return view('chapter.editChapter')->with([
            'chapter' => $chapter,
        ]);

    }

    public function updateArtworkChapter(AddChapterRequest $request) {

        $chapter = Chapter::find($request->chapter_id);

        $chapter->update([
            'title' => $request->title,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        return redirect()->route('bookShow',['id'=>$chapter->artwork->id])->with('success', 'Информация о главе обновлена');

    }
}
