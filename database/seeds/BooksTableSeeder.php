<?php

use App\Book;
use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Book::create([
            'user_id' => 1,
            'status_id' => 1,
            'title' => 'testbook',
            'item_caption' => null,
            'author' => 'bob',
            'item_url' => null,
            'large_image_url' => null,
            'memo' => 'i am so happy',
        ]);
    }
}
