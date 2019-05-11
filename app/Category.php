<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title', 'image_id'];

    public function artworks() {
        return $this -> hasMany('App\Artwork');
    }

    public function image() {
        return $this->belongsTo('App\Image');
    }
}
