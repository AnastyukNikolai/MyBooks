<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $guarded = [];

    public function artworks() {
        return $this -> hasMany('App\Artwork');
    }

    public function image() {
        return $this -> belongsTo('App\Image');
    }
}
