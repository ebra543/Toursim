<?php

namespace Database\Seeders;

use App\Models\VehicleType;
use Illuminate\Database\Seeder;

class VehicleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create vehicle types for City Cabs (TaxiServiceID: 1)
        VehicleType::create([
            'TaxiServiceID' => 1,
            'TypeName' => 'Economy',
            'Description' => 'Affordable sedan for up to 4 passengers',
            'MaxPassengers' => 4,
            'PricePerKm' => 1.50,
            'BasePrice' => 5.00,
            'ImageURL' => 'images/vehicles/economy.png',
            'IsActive' => true,
        ]);

        VehicleType::create([
            'TaxiServiceID' => 1,
            'TypeName' => 'SUV',
            'Description' => 'Spacious SUV for up to 6 passengers',
            'MaxPassengers' => 6,
            'PricePerKm' => 2.25,
            'BasePrice' => 7.50,
            'ImageURL' => 'images/vehicles/suv.png',
            'IsActive' => true,
        ]);

        // Create vehicle types for Express Taxi (TaxiServiceID: 2)
        VehicleType::create([
            'TaxiServiceID' => 2,
            'TypeName' => 'Standard',
            'Description' => 'Standard sedan for up to 4 passengers',
            'MaxPassengers' => 4,
            'PricePerKm' => 1.75,
            'BasePrice' => 6.00,
            'ImageURL' => 'images/vehicles/standard.png',
            'IsActive' => true,
        ]);

        VehicleType::create([
            'TaxiServiceID' => 2,
            'TypeName' => 'Minivan',
            'Description' => 'Minivan for up to 7 passengers',
            'MaxPassengers' => 7,
            'PricePerKm' => 2.50,
            'BasePrice' => 8.00,
            'ImageURL' => 'images/vehicles/minivan.png',
            'IsActive' => true,
        ]);

        // Create vehicle types for Luxury Rides (TaxiServiceID: 3)
        VehicleType::create([
            'TaxiServiceID' => 3,
            'TypeName' => 'Premium',
            'Description' => 'Luxury sedan for up to 4 passengers',
            'MaxPassengers' => 4,
            'PricePerKm' => 3.00,
            'BasePrice' => 10.00,
            'ImageURL' => 'images/vehicles/premium.png',
            'IsActive' => true,
        ]);

        VehicleType::create([
            'TaxiServiceID' => 3,
            'TypeName' => 'Executive',
            'Description' => 'Executive SUV for up to 6 passengers',
            'MaxPassengers' => 6,
            'PricePerKm' => 4.00,
            'BasePrice' => 15.00,
            'ImageURL' => 'images/vehicles/executive.png',
            'IsActive' => true,
        ]);
    }
}
