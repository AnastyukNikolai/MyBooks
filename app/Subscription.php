<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    public function type() {
        return $this -> belongsTo('App\Subscription_type');
    }
}
