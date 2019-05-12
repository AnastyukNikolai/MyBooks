<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Financial_operation extends Model
{
    protected $guarded = [];

    public function status() {
        return $this -> belongsTo('App\Financial_operation_status', 'status_id');
    }

    public function type() {
        return $this -> belongsTo('App\Types_of_financial_operation', 'type_id');
    }

    public function payer() {
        return $this -> belongsTo('App\User', 'payer_id');
    }

    public function receiver() {
        return $this -> belongsTo('App\User', 'receiver_id');
    }

    public function buy_chapters() {
        return $this -> hasMany('App\Buying_a_chapter');
    }

    public function buy_artwork() {
        return $this -> hasOne('App\Subscription');
    }



}
