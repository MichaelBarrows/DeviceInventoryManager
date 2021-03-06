<?php

use Illuminate\Database\Seeder;

class DevicesTableSeeder extends Seeder
{
    /**
     * Seed data for devices table, generated by faker
     */
    public function run()
    {
        $faker = \Faker\Factory::create('en_GB');
        for ($i = 0; $i < 6; $i++) {
            DB::table('devices')->insert([
                'serial_number' => $faker->unique()->numerify('########'),
                'imei' => $faker->unique()->numerify('################'),
                'device_model_id' => $faker->numberBetween(1, 4),
            ]);
        }
    }
}
