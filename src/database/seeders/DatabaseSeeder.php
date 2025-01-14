<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 各シーダーを呼び出し
        $this->call(AreaSeeder::class);
        $this->call(GenreSeeder::class);
        $this->call(ShopSeeder::class);
    }
}
