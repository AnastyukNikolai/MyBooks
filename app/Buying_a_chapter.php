<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buying_a_chapter extends Model
{
    protected $guarded = [];

    public function chapter() {
        return $this -> belongsTo('App\Chapter');
    }

    public function operation() {
        return $this -> belongsTo('App\Financial_operation');
    }
}
