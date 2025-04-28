<?php

namespace Database\Seeders;

use App\Models\TaxiService;
use App\Models\Location;
use Illuminate\Database\Seeder;

class TaxiServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create taxi services
        TaxiService::create([
            'ServiceName' => 'City Cabs',
            'Description' => 'Reliable taxi service for city transportation',
            'LocationID' => 1, // Assuming location ID 1 exists
            'AverageRating' => 4.5,
            'TotalRatings' => 120,
            'LogoURL' => 'images/taxi/citycabs_logo.png',
            'Website' => 'https://citycabs.example.com',
            'Phone' => '123-456-7890',
            'Email' => 'info@citycabs.example.com',
            'IsActive' => true,
            'ManagerID' => 1, // Assuming user ID 1 is admin
        ]);

        TaxiService::create([
            'ServiceName' => 'Express Taxi',
            'Description' => 'Fast and efficient taxi service',
            'LocationID' => 2, // Assuming location ID 2 exists
            'AverageRating' => 4.2,
            'TotalRatings' => 85,
            'LogoURL' => 'images/taxi/expresstaxi_logo.png',
            'Website' => 'https://expresstaxi.example.com',
            'Phone' => '987-654-3210',
            'Email' => 'info@expresstaxi.example.com',
            'IsActive' => true,
            'ManagerID' => 1,
        ]);

        TaxiService::create([
            'ServiceName' => 'Luxury Rides',
            'Description' => 'Premium taxi service with luxury vehicles',
            'LocationID' => 3, // Assuming location ID 3 exists
            'AverageRating' => 4.8,
            'TotalRatings' => 65,
            'LogoURL' => 'images/taxi/luxuryrides_logo.png',
            'Website' => 'https://luxuryrides.example.com',
            'Phone' => '555-123-4567',
            'Email' => 'info@luxuryrides.example.com',
            'IsActive' => true,
            'ManagerID' => 1,
        ]);
    }
}
