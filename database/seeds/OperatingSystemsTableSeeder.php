<?php

use Illuminate\Database\Seeder;

class OperatingSystemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('operating_systems')->insert([
            ['name' => 'iOS'],
            ['name' => 'Android'],
        ]);
    }
}
