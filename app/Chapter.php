<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{

    protected $fillable = ['title', 'description', 'artwork_id', 'price', 'number', 'text_link'];


    public function users() {
        return $this -> belongsToMany('App\User', 'buying_a_chapters');
    }

    public function artwork() {
        return $this -> belongsTo('App\Artwork');
    }
}
