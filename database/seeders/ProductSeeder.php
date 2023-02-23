<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 50; $i++) {
            DB::table('products')->insert([
                'name' => $faker->sentence(6),
                'code' => $faker->word(),
                'price' => $faker->randomFloat(2, 100000, null),
                'created_at' => $faker->dateTime('now', null),
                'updated_at' => $faker->dateTime('now', null),
            ]);

            // DB::table('products')->insert([
            //     'name' => 'donuts',
            //     'code' => 'snack',
            //     'price' => 100000,
            // ]);
        }
    }
}
