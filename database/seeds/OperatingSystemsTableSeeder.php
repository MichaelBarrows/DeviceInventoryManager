<?php

use Illuminate\Database\Seeder;

class OperatingSystemsTableSeeder extends Seeder
{
    /**
     * Seed data for the operating systems table
     */
    public function run()
    {
        DB::table('operating_systems')->insert([
            ['name' => 'iOS'],
            ['name' => 'Android'],
        ]);
    }
}
