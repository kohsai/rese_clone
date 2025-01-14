<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 13のジャンルを追加
        DB::table('genres')->insert([
            ['genre_name' => '寿司'],
            ['genre_name' => '焼肉'],
            ['genre_name' => '居酒屋'],
            ['genre_name' => 'イタリアン'],
            ['genre_name' => 'ラーメン'],
            ['genre_name' => 'フレンチ'],
            ['genre_name' => '和食'],
            ['genre_name' => 'カフェ'],
            ['genre_name' => '洋食'],
            ['genre_name' => '中華'],
            ['genre_name' => 'アジアン'],
            ['genre_name' => 'インド・ネパール'],
            ['genre_name' => 'その他'],
        ]);
    }
}
