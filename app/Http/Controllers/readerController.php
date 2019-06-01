<?php

namespace App\Http\Controllers;

use App\Artwork;
use App\Http\Requests\AddReviewRequest;
use App\Like;
use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Chapter;
use App\User;
use phpDocumentor\Reflection\Types\Integer;

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

    public function addReview($id) {

       $artwork_id = Artwork::find($id)->id;

       return view('review.addReview')->with([
           'artwork_id' => $artwork_id,
       ]);

    }

    public function storeReview(AddReviewRequest $request) {
        $artwork = Artwork::find($request->artwork_id);

        if ($artwork->users->find(Auth::id())== false&&Auth::user()->chapters->where('artwork_id', $artwork->id)==false) {
            $error = 'Ошибка добавления отзыва';
            return redirect()->back()->with(['error'=>$error]);
        }
        else {
                Review::create([
                'title' => $request->title,
                'text' => $request->textrev,
                'assessment' => $request->assessment,
                'artwork_id' => $request->artwork_id,
                'user_id' => $request->user_id,
            ]);

            return redirect()->back()->with('success', 'Отзыв успешно добавлен');
        }

    }

    public function editReview($id) {

        $review = Review::find($id);

        return view('review.editReview')->with([
            'review' => $review,
        ]);

    }


    public function updateReview(AddReviewRequest $request) {

        $review = Review::find($request->review_id);
        $review->update([
            'title' => $request->title,
            'text' => $request->textrev,
            'assessment' => $request->assessment,
        ]);

        return redirect()->back()->with('success', 'Отзыв успешно редактирован');
    }

    public function deleteReview($id) {

        $review = Review::find($id);
        $review->delete();

        return redirect()->back()->with('success', 'Отзыв успешно удален');
    }

    public function addLike($id) {

        $like = Like::where('artwork_id', $id)->where('user_id', Auth::id())->first();

        if ($like == null) {
            Like::create([
                'artwork_id' => $id,
                'user_id' => Auth::id(),
            ]);

            return redirect()->back()->with('success', 'Отмечено как понравившееся');
        }
        else {
            $error = 'Вы уже отметили данную книгу как понравившуюся';
            return redirect()->back()->with(['error'=>$error]);
        }
    }

    public function deleteLike($artwork_id, $user_id) {

        $like = Like::where('artwork_id', $artwork_id)->where('user_id', $user_id)->first();
        $like->forceDelete();

        return redirect()->back()->with('success', 'Лайк успешно удален');
    }

}
