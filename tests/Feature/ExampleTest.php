<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $user = User::create(['name' => 'test', 'password' => 'email'])->fresh();
        $databaseUser = User::first();
        $response = $this->get('/');

        $response->assertStatus(200);
        $this->assertEquals($user, $databaseUser);

    }
}
