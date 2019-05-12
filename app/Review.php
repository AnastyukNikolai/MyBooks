<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $guarded = [];

    public function artwork() {
        return $this -> belongsTo('App\Artwork');
    }

    public function user() {
        return $this -> belongsTo('App\User');
    }
}
