<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function user()
    {
        return $this->belongsTo('APP\User');
    }

    public function books()
    {
        return $this->belongsToMany('App\Book');
    }
}
