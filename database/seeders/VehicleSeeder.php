<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create vehicles for City Cabs (TaxiServiceID: 1)
        // Economy vehicles (VehicleTypeID: 1)
        Vehicle::create([
            'TaxiServiceID' => 1,
            'VehicleTypeID' => 1,
            'RegistrationNumber' => 'ABC-1234',
            'Model' => 'Toyota Corolla',
            'Year' => 2020,
            'Color' => 'White',
            'IsActive' => true,
        ]);

        Vehicle::create([
            'TaxiServiceID' => 1,
            'VehicleTypeID' => 1,
            'RegistrationNumber' => 'DEF-5678',
            'Model' => 'Honda Civic',
            'Year' => 2021,
            'Color' => 'Silver',
            'IsActive' => true,
        ]);

        // SUV vehicles (VehicleTypeID: 2)
        Vehicle::create([
            'TaxiServiceID' => 1,
            'VehicleTypeID' => 2,
            'RegistrationNumber' => 'GHI-9012',
            'Model' => 'Toyota RAV4',
            'Year' => 2019,
            'Color' => 'Black',
            'IsActive' => true,
        ]);

        // Create vehicles for Express Taxi (TaxiServiceID: 2)
        // Standard vehicles (VehicleTypeID: 3)
        Vehicle::create([
            'TaxiServiceID' => 2,
            'VehicleTypeID' => 3,
            'RegistrationNumber' => 'JKL-3456',
            'Model' => 'Nissan Altima',
            'Year' => 2020,
            'Color' => 'Blue',
            'IsActive' => true,
        ]);

        // Minivan vehicles (VehicleTypeID: 4)
        Vehicle::create([
            'TaxiServiceID' => 2,
            'VehicleTypeID' => 4,
            'RegistrationNumber' => 'MNO-7890',
            'Model' => 'Honda Odyssey',
            'Year' => 2021,
            'Color' => 'Gray',
            'IsActive' => true,
        ]);

        // Create vehicles for Luxury Rides (TaxiServiceID: 3)
        // Premium vehicles (VehicleTypeID: 5)
        Vehicle::create([
            'TaxiServiceID' => 3,
            'VehicleTypeID' => 5,
            'RegistrationNumber' => 'PQR-1234',
            'Model' => 'Mercedes-Benz E-Class',
            'Year' => 2022,
            'Color' => 'Black',
            'IsActive' => true,
        ]);

        // Executive vehicles (VehicleTypeID: 6)
        Vehicle::create([
            'TaxiServiceID' => 3,
            'VehicleTypeID' => 6,
            'RegistrationNumber' => 'STU-5678',
            'Model' => 'BMW X5',
            'Year' => 2022,
            'Color' => 'White',
            'IsActive' => true,
        ]);
    }
}
