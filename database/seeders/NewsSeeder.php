<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run()
    {
        DB::table('news')->insert([
            'Image' => 'benzema',
            'Description' => 'bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb',
            'NewsDate' => '2022-03-04 12:53:22',
            'Category' => 'football',
        ]);
    }
}
