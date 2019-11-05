<?php

use Illuminate\Database\Seeder;

class DeviceUserPivotTableSeeder extends Seeder
{
    /**
     * Seed data for device and user relations
     */
    public function run()
    {
        DB::table('device_user')->insert([
            ['device_id' => 1, 'user_id' => 1, 'assignment_start' => '2019-01-01', 'assignment_end' => '2019-02-01'],
            ['device_id' => 2, 'user_id' => 2, 'assignment_start' => '2019-01-01', 'assignment_end' => null],
            ['device_id' => 3, 'user_id' => 3, 'assignment_start' => '2019-01-01', 'assignment_end' => '2019-02-01'],
            ['device_id' => 4, 'user_id' => 4, 'assignment_start' => '2019-01-01', 'assignment_end' => null],
            ['device_id' => 5, 'user_id' => 5, 'assignment_start' => '2019-01-01', 'assignment_end' => null],
            ['device_id' => 6, 'user_id' => 2, 'assignment_start' => '2019-01-01', 'assignment_end' => null],
            ['device_id' => 1, 'user_id' => 5, 'assignment_start' => '2019-02-02', 'assignment_end' => null],
            ['device_id' => 3, 'user_id' => 5, 'assignment_start' => '2019-02-02', 'assignment_end' => null],
        ]);
    }
}
