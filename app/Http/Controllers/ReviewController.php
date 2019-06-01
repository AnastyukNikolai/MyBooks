<?php

namespace App\Http\Controllers;

use App\Artwork;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function show($id) {

        $artwork=Artwork::find($id);
        $reviews=$artwork->reviews;
        $message=' ';

        return view('review.showReviews')
            ->with([
                'artwork' => $artwork,
                'reviews' => $reviews,
                'message' => $message,
            ]);

    }

}
