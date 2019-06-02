<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    public function messages() {
        return $this -> hasMany('App\Message');
    }

    public function users() {
        return $this -> belongsToMany('App\User', 'message_users');
    }

    public function user() {
        return $this -> belongsTo('App\User');
    }

    public function type() {
        return $this -> belongsTo('App\MessageType');
    }

    public function message() {
        return $this -> belongsTo('App\Message');
    }
}
