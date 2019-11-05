<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(NetworkProvidersTableSeeder::class);
        $this->call(PhoneNumbersTableSeeder::class);
        $this->call(SimCardsTableSeeder::class);
        $this->call(ManufacturersTableSeeder::class);
        $this->call(OperatingSystemsTableSeeder::class);
        $this->call(DeviceTypesTableSeeder::class);
        $this->call(DeviceModelsTableSeeder::class);
        $this->call(DevicesTableSeeder::class);
        $this->call(DeviceUserPivotTableSeeder::class);
        $this->call(DeviceSimCardPivotTableSeeder::class);
        $this->call(PhoneNumberSimCardPivotTableSeeder::class);
    }
}
