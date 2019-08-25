<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    $status = ['未読', '読み中', '欲しい', '完読'];
    return [
        "user_id" => function () {return factory(\App\User::class)->create()->id;},
        "title" => $faker->word,
        "itemCaption" => $faker->sentence,
        "author" => $faker->name,
        "itemUrl" => 'https://placehold.jp/200x200.png',
        "largeImageUrl" => 'https://placehold.jp/200x200.png',
        "memo" => $faker->sentence,
        "status" => $status[rand(0, 3)],
    ];
});
