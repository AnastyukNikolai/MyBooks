<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work_status extends Model
{
    protected $guarded = [];

    public function artworks() {
        return $this -> hasMany('App\Artwork');
    }
}
