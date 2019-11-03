<?php

use Illuminate\Database\Seeder;

class PhoneNumberSimCardPivotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('phone_number_sim_card')->insert([
            ['phone_number_id' => 1, 'sim_card_id' => 1, 'assignment_start' => '2019-01-01', 'assignment_end' => null],
            ['phone_number_id' => 2, 'sim_card_id' => 2, 'assignment_start' => '2019-01-01', 'assignment_end' => null],
            ['phone_number_id' => 3, 'sim_card_id' => 3, 'assignment_start' => '2019-01-01', 'assignment_end' => null],
            ['phone_number_id' => 4, 'sim_card_id' => 4, 'assignment_start' => '2019-01-01', 'assignment_end' => null],
            ['phone_number_id' => 5, 'sim_card_id' => 5, 'assignment_start' => '2019-01-01', 'assignment_end' => null],
            ['phone_number_id' => 6, 'sim_card_id' => 6, 'assignment_start' => '2019-01-01', 'assignment_end' => null],
        ]);
    }
}
