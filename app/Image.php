<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['img_link', 'category_id'];

    public function artwork() {
        return $this -> hasOne('App\Artwork');
    }

    public function language() {
        return $this -> hasOne('App\Language');
    }

    public function category() {
        return $this -> belongsTo('App\Image_category');
    }
}
