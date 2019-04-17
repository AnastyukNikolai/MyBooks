<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function artworks() {
        return $this -> belongsToMany('App\Artwork', 'work_tags');
    }
}
