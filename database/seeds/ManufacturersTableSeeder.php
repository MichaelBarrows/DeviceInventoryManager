<?php

use Illuminate\Database\Seeder;

class ManufacturersTableSeeder extends Seeder
{
    /**
     * Seed data for manufacturers table
     *
     * @return void
     */
    public function run()
    {
        DB::table('manufacturers')->insert([
            ['name' => 'Apple'],
            ['name' => 'Samsung'],
            ['name' => 'Sony'],
        ]);
    }
}
