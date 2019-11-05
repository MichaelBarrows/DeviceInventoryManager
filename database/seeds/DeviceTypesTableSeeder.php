<?php

use Illuminate\Database\Seeder;

class DeviceTypesTableSeeder extends Seeder
{
    /**
     * Seed data for device types table
     */
    public function run()
    {
        DB::table('device_types')->insert([
            ['type' => 'mobile'],
            ['type' => 'tablet'],
        ]);
    }
}
