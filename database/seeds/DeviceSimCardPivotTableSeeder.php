<?php

use Illuminate\Database\Seeder;

class DeviceSimCardPivotTableSeeder extends Seeder
{
    /**
     * Seed data for device and sim card relations
     */
    public function run()
    {
        DB::table('device_sim_card')->insert([
            ['device_id' => 1, 'sim_card_id' => 1, 'assignment_start' => '2019-01-01', 'assignment_end' => null],
            ['device_id' => 2, 'sim_card_id' => 2, 'assignment_start' => '2019-01-01', 'assignment_end' => null],
            ['device_id' => 3, 'sim_card_id' => 3, 'assignment_start' => '2019-01-01', 'assignment_end' => null],
            ['device_id' => 4, 'sim_card_id' => 4, 'assignment_start' => '2019-01-01', 'assignment_end' => null],
            ['device_id' => 5, 'sim_card_id' => 5, 'assignment_start' => '2019-01-01', 'assignment_end' => null],
            ['device_id' => 6, 'sim_card_id' => 6, 'assignment_start' => '2019-01-01', 'assignment_end' => null],
        ]);
    }
}
