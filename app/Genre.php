<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    public function artworks() {
        return $this -> belongsToMany('App\Artwork', 'work_genres');
    }
}
