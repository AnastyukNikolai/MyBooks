<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['image_path', 'category_id'];

    public function artwork() {
        return $this -> hasOne('App\Artwork');
    }

    public function category() {
        return $this -> hasOne('App\Category');
    }

    public function language() {
        return $this -> hasOne('App\Language');
    }
}
