<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $guarded = [];

    public function artwork() {
        return $this -> belongsTo('App\Artwork');
    }

    public function user() {
        return $this -> belongsTo('App\User');
    }
}
