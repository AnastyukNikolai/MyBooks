<?php

namespace App\Http\Controllers;


use App\Artwork;
use App\Image;
use App\Chapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\Http\Requests;

class IndexController extends Controller
{
    public function indexShow() {

       $artworks=Artwork::all();

        return view('page')->with(['artworks' => $artworks]);

    }

    public function bookShow($id) {

        $artwork=Artwork::find($id);
        $language=$artwork->language;
        $artwork_views=$artwork->views;
        $chapters=$artwork->chapters->sortBy('number');
        $first_chapter=$artwork->chapters->where('number', 1)->first();
        Artwork::where('id',$id)->update(['views' => $artwork_views+1]);

        return view('bookPage')->with(['artwork' => $artwork,
                                             'language' => $language,
                                             'first_chapter' => $first_chapter,
                                             'chapters' => $chapters
                                             ]);


    }

    public function chapterShow($id) {

        $chapter=Chapter::find($id);
        $artwork_id=$chapter->artwork->id;
        $next_chapter=Chapter::where('artwork_id',$artwork_id)->where('number',$chapter->number+1)->first();
        $previous_chapter=Chapter::where('artwork_id',$artwork_id)->where('number',$chapter->number-1)->first();
        $text_link=$chapter->text_link;
        $link= $text_link.'.txt';
        $content = Storage::get($link);
        $content = iconv('CP1251', 'UTF-8', $content);
        $content = preg_replace( "#\r?\n#", "<br />", $content );
        return view('chapterPage')->with(['chapter' => $chapter,
                                                'content' => $content,
                                                'next_chapter' => $next_chapter,
                                                'previous_chapter' => $previous_chapter,
                                               ]);


    }

}
