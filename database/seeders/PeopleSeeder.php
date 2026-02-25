<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class PeopleSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create(app()->getLocale());

        $data = [];
        for ($i = 0; $i < 20; $i++) {
            $data[] = [
                'name' => $faker->name(),
                'mail' => $faker->unique()->safeEmail(),
                'age' => $faker->numberBetween(18, 80),
            ];
        }

        DB::table('people')->insert($data);
    }
}
