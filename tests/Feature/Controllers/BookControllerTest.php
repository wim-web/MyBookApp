<?php

namespace Tests\Feature;

use App\Book;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->be($this->user);
    }

    public function testMypage()
    {
        $mybooks = factory(Book::class)->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->get('/books');

        $response->assertJson([
            'data' => [
                [
                    'id' => $mybooks->id,
                    'user_id' => $mybooks->user_id,
                    'title' => $mybooks->title,
                    'itemCaption' => $mybooks->itemCaption,
                    'author' => $mybooks->author,
                    'itemUrl' => $mybooks->itemUrl,
                    'largeImageUrl' => $mybooks->largeImageUrl,
                    'status' => $mybooks->status,
                ],
            ]
        ]);
    }

    public function testStoreMybook()
    {
        $requestData = factory(Book::class)->make()->toArray();

        $response = $this->post('/books', $requestData);

        $this->assertDatabaseHas('books', [
            'user_id' => $this->user->id,
            'title' => $requestData['title'],
        ]);
    }

    public function testDeleteMybook()
    {
        $mybook = factory(Book::class)->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->delete("/books/$mybook->id");

        $this->assertDatabaseMissing('books', [
            'id' => $mybook['id'],
            'user_id' => $this->user->id,
        ]);
    }

    public function testUpdateStatus()
    {
        $mybook = factory(Book::class)->create([
            'user_id' => $this->user->id
        ]);

        $requestData = ['status' => 'update'];

        $response = $this->patch("/books/$mybook->id/status", $requestData);

        $this->assertDatabaseHas('books', [
            'id' => $mybook->id,
            'user_id' => $mybook->user_id,
            'status' => 'update',
        ]);
    }

    public function testShowPublicPage()
    {
        $book = factory(Book::class)->create([
            'user_id' => $this->user->id,
        ]);

        $name = $this->user->name;

        $response = $this->get("public/$name/show");

        $response->assertJson([
            'data' => [
                [
                    'user_id' => $this->user->id,
                    'id' => $book->id,
                ]
            ]
        ]);
    }
}
