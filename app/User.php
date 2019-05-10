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
        'name', 'email', 'password', 'refresh_token',
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

    public function comments() {
        return $this -> hasMany('App\Comment');
    }

    public function chapters() {
        return $this -> belongsToMany('App\Chapter', 'buying_a_chapters');
    }

    public function favorites() {
        return $this -> belongsToMany('App\Artwork', 'favorites');
    }

    public function subscriptions() {
        return $this -> belongsToMany('App\Artwork', 'subscriptions');
    }
}
