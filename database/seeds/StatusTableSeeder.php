<?php

use App\Status;
use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::insert([
            ["status" => 'つんどく'],
            ["status" => '読み中'],
            ["status" => '読み終'],
            ["status" => '欲しい'],
        ]);
    }
}
