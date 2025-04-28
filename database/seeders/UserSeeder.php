<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'email' => 'admin@example.com',
            'password_hash' => Hash::make('12345678'),
            'password_salt' => '',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'phone' => '1234567890',
            'user_type' => 'admin',
            'registration_date' => now(),
            'status' => 1, // 1=Active, 0=Inactive
            'is_email_verified' => true,
            'is_phone_verified' => true,
        ]);

        // Create some regular users
        User::create([
            'email' => 'user1@example.com',
            'password_hash' => Hash::make('password'),
            'password_salt' => '',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '9876543210',
            'user_type' => 'customer',
            'registration_date' => now(),
            'status' => 1, // 1=Active, 0=Inactive
            'is_email_verified' => true,
            'is_phone_verified' => true,
        ]);

        User::create([
            'email' => 'user2@example.com',
            'password_hash' => Hash::make('password'),
            'password_salt' => '',
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'phone' => '5551234567',
            'user_type' => 'customer',
            'registration_date' => now(),
            'status' => 1, // 1=Active, 0=Inactive
            'is_email_verified' => true,
            'is_phone_verified' => true,
        ]);
    }
}
