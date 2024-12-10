<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    $param = [
      'name' => 'tony',
    ];
    DB::table('shops')->insert($param);
    $param = [
     'name' => 'jack',
    ];
    DB::table('shops')->insert($param);
    $param = [
      'name' => 'sara',
    ];
    DB::table('shops')->insert($param);
    $param = [
      'name' => 'saly',
    ];
    DB::table('shops')->insert($param);
    }
}
