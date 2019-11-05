<?php

use Illuminate\Database\Seeder;

class DeviceModelsTableSeeder extends Seeder
{
    /**
     * Seed data for device models 
     *
     */
    public function run()
    {
        DB::table('device_models')->insert([
            ['manufacturer_id' => 1, 'name' => 'iPhone 10', 'device_type_id' => 1, 'operating_system_id' => 1],
            ['manufacturer_id' => 2, 'name' => 'Galaxy S8', 'device_type_id' => 1, 'operating_system_id' => 2],
            ['manufacturer_id' => 2, 'name' => 'Galaxy Tab A', 'device_type_id' => 2, 'operating_system_id' => 2],
            ['manufacturer_id' => 3, 'name' => 'Xperia 10', 'device_type_id' => 1, 'operating_system_id' => 2],
            ['manufacturer_id' => 1, 'name' => 'iPad Mini', 'device_type_id' => 2, 'operating_system_id' => 1],
        ]);
    }
}
