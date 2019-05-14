<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chapter extends Model
{

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['title', 'description', 'artwork_id', 'price', 'number', 'file_id', 'min_amount', 'announcement'];


    public function purchases() {
        return $this -> hasMany('App\Buying_a_chapter', 'chapter_id');
    }

    public function users() {
        return $this -> belongsToMany('App\User', 'buying_a_chapters');
    }

    public function financial_operations() {
        return $this -> belongsToMany('App\Financial_operation', 'buying_a_chapters');
    }

    public function artwork() {
        return $this -> belongsTo('App\Artwork');
    }
}
