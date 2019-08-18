<?php

use Illuminate\Database\Seeder;

class BookTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $books = App\Book::all();
        $tags = App\Tag::all();
        foreach ($books as $book) {
            $book->tags()->attach(
                $tags->random(rand(1, 4))->pluck('id')->toArray()
            );
        }
    }
}
