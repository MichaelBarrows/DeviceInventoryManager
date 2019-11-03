<?php

use Illuminate\Database\Seeder;

class SimCardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('en_GB');
        for ($i = 0; $i < 6; $i++) {
            DB::table('sim_cards')->insert([
                'sim_number' => $faker->unique()->randomNumber($nbDigits = 8),
                'network_provider_id' => $faker->numberBetween(1, 2),
            ]);
        }
    }
}
