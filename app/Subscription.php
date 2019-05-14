<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    public function artwork() {
        return $this -> belongsTo('App\Chapter');
    }

    public function operation() {
        return $this -> belongsTo('App\Financial_operation');
    }
}
