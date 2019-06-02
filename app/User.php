<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends \TCG\Voyager\Models\User
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'refresh_token', 'balance',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function artworks() {
        return $this -> hasMany('App\Artwork');
    }

    public function purchase_transactions() {
        return $this -> hasMany('App\Financial_operation', 'payer_id');
    }

    public function sale_transactions() {
        return $this -> hasMany('App\Financial_operation', 'receiver_id');
    }

    public function reviews() {
        return $this -> hasMany('App\Review');
    }

    public function buy_chapters() {
        return $this -> hasMany('App\Buying_a_chapter');
    }

    public function outgoing_messages() {
        return $this -> hasMany('App\Message');
    }

    public function favorites() {
        return $this -> belongsToMany('App\Artwork', 'favorites');
    }

    public function liked() {
        return $this -> belongsToMany('App\Artwork', 'likes');
    }

    public function incoming_messages() {
        return $this -> belongsToMany('App\Message', 'message_users');
    }

    public function subscriptions() {
        return $this -> belongsToMany('App\Artwork', 'subscriptions');
    }

    public function chapters() {
        return $this -> belongsToMany('App\Chapter', 'buying_a_chapters');
    }
}
