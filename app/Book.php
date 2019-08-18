<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'itemCaption',
        'author',
        'itemUrl',
        'largeImageUrl',
        'status',
    ];

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }
}
