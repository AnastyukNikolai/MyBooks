<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
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
    public function favorites() {
        return $this -> belongsToMany('App\Artwork', 'favorites');
    }

    public function liked() {
        return $this -> belongsToMany('App\Artwork', 'likes');
    }

    public function subscriptions() {
        return $this -> belongsToMany('App\Artwork', 'subscriptions');
    }
}
