<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        "user_id" => function () {return factory(\App\User::class)->create()->id;},
        "status_id" => function () {return factory(\App\Status::class)->create()->id;},
        "title" => $faker->word,
        "item_caption" => $faker->sentence,
        "author" => $faker->name,
        "item_url" => $faker->imageUrl(),
        "large_image_url" => $faker->imageUrl(),
        "memo" => $faker->sentence,
    ];
});
