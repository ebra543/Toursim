<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\City;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create cities first if they don't exist
        $city1 = City::firstOrCreate(
            ['CityName' => 'New York'],
            [
                'CountryID' => 1, // Assuming USA
                'IsActive' => true,
                'IsPopular' => true,
            ]
        );

        $city2 = City::firstOrCreate(
            ['CityName' => 'Los Angeles'],
            [
                'CountryID' => 1, // Assuming USA
                'IsActive' => true,
                'IsPopular' => true,
            ]
        );

        $city3 = City::firstOrCreate(
            ['CityName' => 'Chicago'],
            [
                'CountryID' => 1, // Assuming USA
                'IsActive' => true,
                'IsPopular' => true,
            ]
        );

        // Create locations
        Location::create([
            'LocationName' => 'Downtown',
            'CityID' => $city1->id,
            'Description' => 'Downtown area with major attractions',
            'Latitude' => 40.7128,
            'Longitude' => -74.0060,
            'IsPopular' => true,
        ]);

        Location::create([
            'LocationName' => 'Airport',
            'CityID' => $city1->id,
            'Description' => 'International Airport',
            'Latitude' => 40.6413,
            'Longitude' => -73.7781,
            'IsPopular' => true,
        ]);

        Location::create([
            'LocationName' => 'Beach Area',
            'CityID' => $city2->id,
            'Description' => 'Popular beach destination',
            'Latitude' => 34.0522,
            'Longitude' => -118.2437,
            'IsPopular' => true,
        ]);
    }
}
