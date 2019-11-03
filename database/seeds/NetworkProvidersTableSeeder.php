<?php

use Illuminate\Database\Seeder;

class NetworkProvidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('network_providers')->insert([
            ['provider' => 'O2'],
            ['provider' => 'Vodafone'],
        ]);
    }
}
