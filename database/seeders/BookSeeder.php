<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $fake = [
            ['book' => 'Khoa học viễn tưởng'],
            ['book' => 'Tình cảm'],
            ['book' => 'giao khoa'],
            ['book' => 'Dạy làm giàu'],
            ['book' => 'Quản trị'],
        ];
        dd($fake[1]);
        foreach ($fake as $key => $value) {
            dd($value['book']);
        }
    }
}
