<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{

    public function users() {
        return $this -> belongsToMany('App\User', 'buying_a_chapters');
    }

    public function artwork() {
        return $this -> belongsTo('App\Artwork');
    }
}
