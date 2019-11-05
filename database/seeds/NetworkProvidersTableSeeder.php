<?php

use Illuminate\Database\Seeder;

class NetworkProvidersTableSeeder extends Seeder
{
    /**
     * Seed files for the network providers table
     */
    public function run()
    {
        DB::table('network_providers')->insert([
            ['provider' => 'O2'],
            ['provider' => 'Vodafone'],
        ]);
    }
}
