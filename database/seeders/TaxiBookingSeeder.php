<?php

namespace Database\Seeders;

use App\Models\TaxiBooking;
use App\Models\Booking;
use Illuminate\Database\Seeder;

class TaxiBookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create bookings first
        $booking1 = Booking::create([
            'UserID' => 2, // Regular user (user1@example.com)
            'BookingDate' => now()->subDays(5),
            'TotalAmount' => 25.50,
            'Status' => 4, // 1=Pending, 2=Confirmed, 3=Cancelled, 4=Completed
            'PaymentStatus' => 2, // 1=Pending, 2=Paid, 3=Refunded, 4=Failed
            'BookingType' => 'taxi',
        ]);

        $booking2 = Booking::create([
            'UserID' => 3, // Regular user (user2@example.com)
            'BookingDate' => now()->subDays(2),
            'TotalAmount' => 42.75,
            'Status' => 2, // 1=Pending, 2=Confirmed, 3=Cancelled, 4=Completed
            'PaymentStatus' => 2, // 1=Pending, 2=Paid, 3=Refunded, 4=Failed
            'BookingType' => 'taxi',
        ]);

        $booking3 = Booking::create([
            'UserID' => 2, // Regular user (user1@example.com)
            'BookingDate' => now(),
            'TotalAmount' => 75.00,
            'Status' => 1, // 1=Pending, 2=Confirmed, 3=Cancelled, 4=Completed
            'PaymentStatus' => 1, // 1=Pending, 2=Paid, 3=Refunded, 4=Failed
            'BookingType' => 'taxi',
        ]);

        // Create taxi bookings
        TaxiBooking::create([
            'BookingID' => $booking1->id,
            'TaxiServiceID' => 1, // City Cabs
            'VehicleTypeID' => 1, // Economy
            'PickupLocationID' => 1, // Assuming location ID 1 exists
            'DropoffLocationID' => 2, // Assuming location ID 2 exists
            'PickupDateTime' => now()->subDays(5)->addHours(2),
            'EstimatedDistance' => 12.5,
            'DriverID' => 1, // Driver from City Cabs
            'VehicleID' => 1, // Toyota Corolla
        ]);

        TaxiBooking::create([
            'BookingID' => $booking2->id,
            'TaxiServiceID' => 2, // Express Taxi
            'VehicleTypeID' => 3, // Standard
            'PickupLocationID' => 3, // Assuming location ID 3 exists
            'DropoffLocationID' => 1, // Assuming location ID 1 exists
            'PickupDateTime' => now()->addDays(1),
            'EstimatedDistance' => 18.2,
            'DriverID' => 2, // Driver from Express Taxi
            'VehicleID' => 4, // Nissan Altima
        ]);

        TaxiBooking::create([
            'BookingID' => $booking3->id,
            'TaxiServiceID' => 3, // Luxury Rides
            'VehicleTypeID' => 5, // Premium
            'PickupLocationID' => 2, // Assuming location ID 2 exists
            'DropoffLocationID' => 3, // Assuming location ID 3 exists
            'PickupDateTime' => now()->addDays(3),
            'EstimatedDistance' => 15.0,
            'DriverID' => 3, // Driver from Luxury Rides
            'VehicleID' => 6, // Mercedes-Benz E-Class
        ]);
    }
}
