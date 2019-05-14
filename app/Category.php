<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['title', 'image_id'];

    public function artworks() {
        return $this -> hasMany('App\Artwork');
    }

    public function image() {
        return $this->belongsTo('App\Image');
    }
}
