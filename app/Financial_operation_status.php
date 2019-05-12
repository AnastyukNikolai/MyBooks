<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Financial_operation_status extends Model
{
    protected $guarded = [];

    public function operations() {
        return $this -> hasMany('App\Financial_operation', 'status_id');
    }
}
