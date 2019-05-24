<?php

namespace App\Http\Controllers;


use App\Artwork;
use App\Buying_a_chapter;
use App\Financial_operation;
use App\Image;
use App\Chapter;
use App\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Http\Requests;

class IndexController extends Controller
{

    //главная страница (с фильтрацией и сортировкой)
    public function indexShow($filter_table = null, $filter_id = null, $sort_param = 'created_at') {



        if($filter_table != null) {

            $artworks = $this->filter($filter_table, $filter_id);

            if ($artworks == false) {
                $artworks=Artwork::all();
                $message = 'Все книги';
            }
            if($filter_table == 'categories'&&$artworks!=false&&$artworks->count()!=0) {
                $message = 'Книги в категории \''.$artworks->first()->category->title.'\'';
            }
            elseif($filter_table == 'genres'&&$artworks!=false&&$artworks->count()!=0) {
                $message = 'Книги в жанре \''.$artworks->first()->genres->where('id', $filter_id)->first()->name.'\'';
            }
            elseif($filter_table == 'languages'&&$artworks!=false&&$artworks->count()!=0) {
                $message = 'Язык книг: \''.$artworks->first()->language->title.'\'';
            }
            elseif ($filter_table == 'a'&&$filter_id == 'a') {
                $message = 'Все книги';
            }
        }
        else {
            $artworks=Artwork::all();
            $message = 'Все книги';
        }


        if($sort_param != 'created_at') {
            $artworks = $this->sort($artworks, $sort_param);
            if($sort_param == 'likes') {
                $message .= '; Сортировка по популярности';
            }
            elseif ($sort_param == 'views') {
                $message .= '; Сортировка по просмотрам';
            }
            elseif ($sort_param == 'reviews') {
                $message .= '; Сортировка по отзывам';
            }
        }
        else {
            $artworks = $artworks->sortBy('created_at');
            $message .= '; Сортировка по дате добавления';
        }


        return view('page')->with([
            'artworks' => $artworks,
            'message' => $message,
            'filter_table' => $filter_table,
            'filter_id' => $filter_id,
            'sort_param' => $sort_param,
        ]);

    }

    public function filter($tableName, $id) {

        $className = 'App\\' . studly_case(str_singular($tableName));


        if(class_exists($className)) {
            $model = new $className;
            $model = $model->where('id', $id)->first();
        }
        else {
            return false;
        }

        $artworks = $model->artworks;

        return $artworks;

    }

    public function sort($artworks, $sort_param) {

        if($sort_param == 'likes'||$sort_param == 'reviews') {

            $order_column = $sort_param . '_count';
            $artworks_id = $artworks->map(function ($artworks) {
                return $artworks->only(['id']);
            });

            $artworks = Artwork::whereIn('id', $artworks_id);

            if($sort_param == 'likes'||$sort_param == 'reviews') {
                $artworks = $artworks->withCount($sort_param)->orderBy($order_column, 'desc')->get();
            }

        }
        elseif ($sort_param == 'views') {
            $artworks = $artworks->sortByDesc($sort_param);
        }

        return $artworks;

    }


    //просмотр страницы отдельной книги
    public function bookShow($id) {

        $artwork=Artwork::find($id);
        $artwork_views=$artwork->views;
        $reviews = $artwork->reviews;
        $chapters = Chapter::withTrashed()->get();
        $chapters=$chapters->where('artwork_id', $artwork->id)->where('announcement', false)->sortBy('created_at');


        $user_chapter = Auth::user()->chapters->where('artwork_id', $artwork->id);

        $announcements=$artwork->chapters->where('announcement', true)->sortBy('created_at');
        $first_chapter=$chapters->sortBy('created_at')->first();

        Artwork::where('id',$id)->update(['views' => $artwork_views+1]);

        return view('artwork.bookPage')->with(['artwork' => $artwork,
                                             'first_chapter' => $first_chapter,
                                             'reviews' => $reviews,
                                             'chapters' => $chapters,
                                             'user_chapter' => $user_chapter,
                                             'announcements' => $announcements,
                                             ]);


    }




    //просмотр главы
   /* public function chapterShow($id) {

        $chapter=Chapter::find($id);
        $artwork_id=$chapter->artwork->id;
        $next_chapter=Chapter::where('artwork_id',$artwork_id)->where('number',$chapter->number+1)->first();
        $previous_chapter=Chapter::where('artwork_id',$artwork_id)->where('number',$chapter->number-1)->first();
        $text_link=$chapter->text_link;
        $link= $text_link;
        $content = \Storage::disk('public')->get($link);

        if(mb_detect_encoding($content)!='UTF-8') {
           $content = iconv('CP1251', 'UTF-8', $content);
        }
        $content = preg_replace( "#\r?\n#", "<br />", $content );

        return view('chapter.chapterPage')->with(['chapter' => $chapter,
                                                'content' => $content,
                                                'next_chapter' => $next_chapter,
                                                'previous_chapter' => $previous_chapter,
                                               ]);


    }*/


    //скачивание главы
   /* public function downloadChapter(Chapter $chapter) {

        return response()->download(storage_path('app/public/' . $chapter->text_link));
    }*/

}
