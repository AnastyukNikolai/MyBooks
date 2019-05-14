<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    public function artworks() {
        return $this -> hasMany('App\Artwork');
    }

    public function image() {
        return $this -> belongsTo('App\Image');
    }
}
