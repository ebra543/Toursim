<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create users for drivers first
        $driver1 = User::create([
            'Email' => 'driver1@example.com',
            'PasswordHash' => Hash::make('password'),
            'PasswordSalt' => '',
            'FirstName' => 'Michael',
            'LastName' => 'Johnson',
            'Phone' => '555-111-2222',
            'UserType' => 'driver',
            'RegistrationDate' => now(),
            'Status' => 1, // 1=Active, 0=Inactive
            'IsEmailVerified' => true,
            'IsPhoneVerified' => true,
        ]);

        $driver2 = User::create([
            'Email' => 'driver2@example.com',
            'PasswordHash' => Hash::make('password'),
            'PasswordSalt' => '',
            'FirstName' => 'Sarah',
            'LastName' => 'Williams',
            'Phone' => '555-333-4444',
            'UserType' => 'driver',
            'RegistrationDate' => now(),
            'Status' => 1, // 1=Active, 0=Inactive
            'IsEmailVerified' => true,
            'IsPhoneVerified' => true,
        ]);

        $driver3 = User::create([
            'Email' => 'driver3@example.com',
            'PasswordHash' => Hash::make('password'),
            'PasswordSalt' => '',
            'FirstName' => 'David',
            'LastName' => 'Brown',
            'Phone' => '555-555-6666',
            'UserType' => 'driver',
            'RegistrationDate' => now(),
            'Status' => 1, // 1=Active, 0=Inactive
            'IsEmailVerified' => true,
            'IsPhoneVerified' => true,
        ]);

        // Create drivers
        Driver::create([
            'UserID' => $driver1->id,
            'TaxiServiceID' => 1, // City Cabs
            'LicenseNumber' => 'DL12345678',
            'ExperienceYears' => 5,
            'Rating' => 4.7,
            'IsActive' => true,
        ]);

        Driver::create([
            'UserID' => $driver2->id,
            'TaxiServiceID' => 2, // Express Taxi
            'LicenseNumber' => 'DL87654321',
            'ExperienceYears' => 3,
            'Rating' => 4.5,
            'IsActive' => true,
        ]);

        Driver::create([
            'UserID' => $driver3->id,
            'TaxiServiceID' => 3, // Luxury Rides
            'LicenseNumber' => 'DL11223344',
            'ExperienceYears' => 7,
            'Rating' => 4.9,
            'IsActive' => true,
        ]);
    }
}
