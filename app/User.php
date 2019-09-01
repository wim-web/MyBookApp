<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /*
     * relation
     */

    public function books()
    {
        return $this->hasMany('App\Book')->orderBy('id', 'desc');
    }

    public function tags()
    {
        return $this->hasMany('App\Tag');
    }

    public function accounts()
    {
        return $this->hasMany('App\SocialAccount');
    }

    /*
     * method
     */

    public function fetchBooks()
    {
        return $this->books()->get();
    }

}
