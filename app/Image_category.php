<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image_category extends Model
{
    public function images() {
        return $this -> hasMany('App\Image');
    }
}
