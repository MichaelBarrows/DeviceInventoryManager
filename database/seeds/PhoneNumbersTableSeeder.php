<?php

use Illuminate\Database\Seeder;

class PhoneNumbersTableSeeder extends Seeder
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
            DB::table('phone_numbers')->insert([
                'phone_number' => $faker->numerify('07#########'),
                'network_provider_id' => $faker->numberBetween(1, 2),
            ]);
        }
    }
}
