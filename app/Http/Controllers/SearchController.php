<?php

namespace App\Http\Controllers;

use App\Artwork;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public static function find(Request $request, $search = null)
    {
        //dd($request->has('q'));

        if ($request->has('q')) {
            $searchArtworks = Artwork::search($request->get('q'))->get();

            return IndexController::indexShow(null, null, 'created_at', $request, $searchArtworks);
        }
        elseif($search != null) {
            $searchArtworks = Artwork::search($search)->get();
            return $searchArtworks;
        }


    }

}
