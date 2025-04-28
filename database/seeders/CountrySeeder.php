<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create countries
        Country::create([
            'CountryName' => 'United States',
            'CountryCode' => 'US',
            'IsActive' => true,
            'IsPopular' => true,
        ]);

        Country::create([
            'CountryName' => 'Canada',
            'CountryCode' => 'CA',
            'IsActive' => true,
            'IsPopular' => true,
        ]);

        Country::create([
            'CountryName' => 'United Kingdom',
            'CountryCode' => 'GB',
            'IsActive' => true,
            'IsPopular' => true,
        ]);

        Country::create([
            'CountryName' => 'France',
            'CountryCode' => 'FR',
            'IsActive' => true,
            'IsPopular' => true,
        ]);

        Country::create([
            'CountryName' => 'Japan',
            'CountryCode' => 'JP',
            'IsActive' => true,
            'IsPopular' => true,
        ]);
    }
}
