<?php

use Illuminate\Database\Seeder;

class DeviceTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('device_types')->insert([
            ['type' => 'mobile'],
            ['type' => 'tablet'],
        ]);
    }
}
