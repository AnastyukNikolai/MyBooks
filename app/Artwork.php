<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    protected $fillable = ['title', 'language_id', 'category_id', 'description', 'image_id', 'user_id', 'status'];

    public function chapters() {
        return $this -> hasMany('App\Chapter');
    }

    public function comments() {
        return $this -> hasMany('App\Comment');
    }

    public function favorites() {
        return $this -> belongsToMany('App\User', 'favorites');
    }

    public function subscriptions() {
        return $this -> belongsToMany('App\User', 'subscriptions');
    }

    public function genres() {
        return $this -> belongsToMany('App\Genre', 'work_genres');
    }

    public function tags() {
        return $this -> belongsToMany('App\Tag', 'work_tags');
    }

    public function image() {
        return $this -> belongsTo('App\Image');
    }

    public function user() {
        return $this -> belongsTo('App\User');
    }

    public function language() {
        return $this -> belongsTo('App\Language');
    }

    public function category() {
        return $this -> belongsTo('App\Category');
    }
}
