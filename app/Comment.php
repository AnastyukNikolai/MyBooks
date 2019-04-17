<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function comments() {
        return $this -> hasMany('App\Comment');
    }

    public function comment() {
        return $this -> belongsTo('App\Comment');
    }

    public function user() {
        return $this -> belongsTo('App\User');
    }
}
