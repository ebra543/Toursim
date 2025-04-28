<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call all seeders in the correct order
        $this->call([
            UserSeeder::class,
            CountrySeeder::class,
            LocationSeeder::class,
            TaxiServiceSeeder::class,
            VehicleTypeSeeder::class,
            VehicleSeeder::class,
            DriverSeeder::class,
            TaxiBookingSeeder::class,
        ]);
    }
}
