<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
   // protected $fillable = ['title', 'language_id', 'category_id', 'description', 'image_id', 'user_id', 'status'];

    protected $guarded = [];

    public function chapters() {
        return $this -> hasMany('App\Chapter');
    }

    public function lovers() {
        return $this -> belongsToMany('App\User', 'favorites');
    }

    public function likers() {
        return $this -> belongsToMany('App\User', 'likes');
    }

    public function reviews() {
        return $this -> hasMany('App\Review');
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

    public function users() {
        return $this -> belongsToMany('App\User', 'subscriptions');
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

    public function status() {
        return $this -> belongsTo('App\Work_status');
    }
}
