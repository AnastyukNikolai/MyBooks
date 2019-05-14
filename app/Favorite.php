<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Favorite extends Model
{

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    public function artwork() {
        return $this -> belongsTo('App\Artwork');
    }

    public function user() {
        return $this -> belongsTo('App\User');
    }
}
