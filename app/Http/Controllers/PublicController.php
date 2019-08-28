<?php

namespace App\Http\Controllers;

use App\User;

class PublicController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param String $name
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function __invoke(String $name, User $user)
    {
        $user = $user->where('name', $name)->first();
        return  $user->books()->paginate(12);
    }
}
