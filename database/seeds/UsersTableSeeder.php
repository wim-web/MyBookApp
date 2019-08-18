<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'test@test.com',
            'email_verified_at' => null,
            'password' => Hash::make('pass'),
        ]);
    }
}
