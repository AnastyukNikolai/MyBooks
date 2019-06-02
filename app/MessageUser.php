<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageUser extends Model
{
    protected $table = 'message_users';
    protected $guarded = [];
    public $timestamps = FALSE;
}
