<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $guarded = [];

    public function artwork() {
        return $this -> belongsTo('App\Chapter');
    }

    public function operation() {
        return $this -> belongsTo('App\Financial_operation');
    }
}
