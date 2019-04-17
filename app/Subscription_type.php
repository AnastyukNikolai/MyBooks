<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription_type extends Model
{
    public function subscriptions() {
        return $this -> hasMany('App\Subscription');
    }
}
