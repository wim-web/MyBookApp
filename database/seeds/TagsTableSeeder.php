<?php

use App\Tag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::insert([
            ['user_id' => 1, "tag" => 'PHP'],
            ['user_id' => 1, "tag" => 'DB'],
            ['user_id' => 1, "tag" => 'JS'],
            ['user_id' => 1, "tag" => 'OTHER'],
        ]);
    }
}
