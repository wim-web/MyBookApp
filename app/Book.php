<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'item_caption',
        'author',
        'item_url',
        'large_image_url',
        'status',
    ];

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    public function status()
    {
        return $this->belongsTo('APP\Status');
    }
}
