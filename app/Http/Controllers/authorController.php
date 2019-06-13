<?php

namespace App\Http\Controllers;
use App\Artwork;
use App\Chapter;
use App\Events\onAddArtworkEvent;
use App\Financial_operation;
use App\Genre;
use App\Category;
use App\Image;
use App\Language;
use App\Work_status;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\AddArtworkRequest;
use App\Http\Requests\AddChapterRequest;
use App\Http\Requests\AddAnonsRequest;


use App\Http\Requests;

class authorController extends Controller
{

    public function artworksShow($id) {

        $user=User::find($id);
        $artworks=$user->artworks;
        $message1='Мои произведения';
        $message2='Произведения автора';
        $n = true;

        return view('artwork.userBooks')
            ->with(['artworks' => $artworks,
                'user' => $user,
                'message1' => $message1,
                'message2' => $message2,
                'n' => $n,
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

        $artwork = Artwork::find($id);
        if($artwork->user_id == Auth::id()) {
            $artwork_id = $id;

            return view('chapter.addChapter')->with([
                'artwork_id' => $artwork_id,
            ]);
        }
        else {
            return redirect()->back();
        }
    }

    public function addChapterAnons($id) {

        $artwork_id = $id;
        $artwork = Artwork::find($id);
        if($artwork->user_id == Auth::id()) {
            return view('chapter.addChapterAnons')->with([
                'artwork_id' => $artwork_id,
            ]);
        }
        else {
            return redirect()->back();
        }

    }

    public function storeChapterAnons(AddAnonsRequest $request) {

        $artwork=Artwork::find($request->artwork_id);
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


    public function deleteAnons($id) {

        $anons = Chapter::find($id);
        $artwork = $anons->artwork;
        if($artwork->user_id == Auth::id()) {
            $anons_operations = $anons->financial_operations->where('type_id', 2)->where('status_id', 3);

            FinancialController::cancellationSponsorship($anons_operations);

            $anons->purchases()->delete();
            $anons->delete();


            return redirect()->back()->with('success', 'Анонс успешно отменен, деньги возвращены спонсорам');
        }
        else {
            return redirect()->back();
        }


    }

    public function editArtworkChapter($id) {

        $chapter = Chapter::find($id);
        $artwork = $chapter->artwork;
        if($artwork->user_id == Auth::id()) {

            return view('chapter.editChapter')->with([
                'chapter' => $chapter,
            ]);
        }
        else {
            return redirect()->back();
        }

    }

    public function updateArtworkChapter(AddChapterRequest $request) {

        $chapter = Chapter::find($request->chapter_id);
        $artwork = $chapter->artwork;
        if($artwork->user_id == Auth::id()) {

            $chapter->update([
                'title' => $request->title,
                'price' => $request->price,
                'description' => $request->description,
            ]);

            return redirect()->route('bookShow', ['id' => $chapter->artwork->id])->with('success', 'Информация о главе обновлена');
        }
        else {
            return redirect()->back();
        }

    }

    public function deleteChapter($id) {

        $chapter = Chapter::find($id);
        $artwork = $chapter->artwork;
        if($artwork->user_id == Auth::id()) {

            $chapter->delete();
            return redirect()->back()->with('success', 'Глава успешно удалена');
        }
        else {
            return redirect()->back();
        }



    }

    public function showChapterFinance($id, $anons) {

        $chapter=Chapter::withTrashed()->where('id', $id)->first();
        $artwork = $chapter->artwork;
        if($artwork->user_id == Auth::id()) {
            $operations = $chapter->financial_operations->sortByDesc('updated_at');
            $n = 0;

            return view('finance.chapterFinancialOperations')
                ->with(['operations' => $operations,
                    'anons' => $anons,
                    'chapter' => $chapter,
                    'n' => $n,
                ]);
        }
        else {
            return redirect()->back();
        }


    }

    public function showUserFinance($id) {

        if($id == Auth::id()) {

        $operations=Financial_operation::where('payer_id', $id)->orWhere('receiver_id', $id)->get()->sortByDesc('updated_at');
        $n = 0;

        return view('finance.userFinancialOperations')
            ->with(['operations' => $operations,
                'n' => $n,
            ]);

            }
        else {
            return redirect()->back();
        }

    }

}
