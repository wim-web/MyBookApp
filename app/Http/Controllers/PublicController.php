<?php

namespace App\Http\Controllers;

use App\User;

class PublicController extends Controller
{


    /**
     * @param String $name
     * @param User $user
     * @return array
     */
    public function __invoke(String $name, User $user)
    {
        $user = $user->where('name', $name)->first();
        return  ['books' => $user->books()->get(), 'user' => $user];
    }
}
