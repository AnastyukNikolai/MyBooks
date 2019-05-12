<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{

    protected $fillable = ['title', 'description', 'artwork_id', 'price', 'number', 'file_id', 'min_amount'];


    public function purchases() {
        return $this -> hasMany('App\Buying_a_chapter', 'chapter_id');
    }

    public function artwork() {
        return $this -> belongsTo('App\Artwork');
    }
}
