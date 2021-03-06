<?php

use Illuminate\Database\Seeder;

class SimCardsTableSeeder extends Seeder
{
    /**
     * Seed data for sim cards table, generated by faker
     */
    public function run()
    {
        $faker = \Faker\Factory::create('en_GB');
        for ($i = 0; $i < 6; $i++) {
            DB::table('sim_cards')->insert([
                'sim_number' => $faker->numerify('##############'),
                'network_provider_id' => $faker->numberBetween(1, 2),
            ]);
        }
    }
}
