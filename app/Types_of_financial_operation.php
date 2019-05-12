<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Types_of_financial_operation extends Model
{
    protected $guarded = [];

    public function operations() {
        return $this -> hasMany('App\Financial_operation', 'type_id');
    }
}
