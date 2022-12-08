<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ingredients')->insert([
            'name' => 'Milch',
            'cup_in_grams' => 150,
            'level_tablespoon_in_grams' => 15,
            'heaped_tablespoon_in_grams' => 0,
            'level_teaspoon_in_grams' => 5,
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('ingredients')->insert([
            'name' => 'Saft',
            'cup_in_grams' => 150,
            'level_tablespoon_in_grams' => 15,
            'heaped_tablespoon_in_grams' => 0,
            'level_teaspoon_in_grams' => 5,
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('ingredients')->insert([
            'name' => 'Wasser',
            'cup_in_grams' => 150,
            'level_tablespoon_in_grams' => 15,
            'heaped_tablespoon_in_grams' => 0,
            'level_teaspoon_in_grams' => 5,
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('ingredients')->insert([
            'name' => 'Sahne',
            'cup_in_grams' => 150,
            'level_tablespoon_in_grams' => 15,
            'heaped_tablespoon_in_grams' => 0,
            'level_teaspoon_in_grams' => 5,
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('ingredients')->insert([
            'name' => 'Wein',
            'cup_in_grams' => 150,
            'level_tablespoon_in_grams' => 15,
            'heaped_tablespoon_in_grams' => 0,
            'level_teaspoon_in_grams' => 5,
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('ingredients')->insert([
            'name' => 'Kakao',
            'cup_in_grams' => 90,
            'level_tablespoon_in_grams' => 5,
            'heaped_tablespoon_in_grams' => 15,
            'level_teaspoon_in_grams' => 4,
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('ingredients')->insert([
            'name' => 'Nüsse',
            'cup_in_grams' => 70,
            'level_tablespoon_in_grams' => 5,
            'heaped_tablespoon_in_grams' => 12,
            'level_teaspoon_in_grams' => 4,
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('ingredients')->insert([
            'name' => 'Öl',
            'cup_in_grams' => 120,
            'level_tablespoon_in_grams' => 10,
            'heaped_tablespoon_in_grams' => 0,
            'level_teaspoon_in_grams' => 4,
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('ingredients')->insert([
            'name' => 'Mehl',
            'cup_in_grams' => 100,
            'level_tablespoon_in_grams' => 15,
            'heaped_tablespoon_in_grams' => 25,
            'level_teaspoon_in_grams' => 3,
            'created_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('ingredients')->insert([
            'name' => 'Zucker',
            'cup_in_grams' => 150,
            'level_tablespoon_in_grams' => 15,
            'heaped_tablespoon_in_grams' => 30,
            'level_teaspoon_in_grams' => 5,
            'created_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
