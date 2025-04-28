<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Bookings table
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('id');
            $table->string('booking_reference')->unique()->notNull();
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->integer('booking_type')->notNull()->comment('1=Tour, 2=Hotel, 3=Taxi, 4=Restaurant, 5=Package');
            $table->dateTime('booking_date')->default(now());
            $table->enum('status',['Pending', 'Confirmed', 'Cancelled', 'Completed'])->default('Pending')->comment('1=Pending, 2=Confirmed, 3=Cancelled, 4=Completed');
            $table->decimal('total_price', 10, 2)->notNull();
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->integer('payment_status')->default(1)->comment('1=Pending, 2=Paid, 3=Refunded, 4=Failed');
            $table->text('special_requests')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->dateTime('last_updated')->default(now());
        });

        // Tour Bookings table
        Schema::create('tour_bookings', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('booking_id')->constrained('bookings', 'id');
            $table->foreignId('tour_id')->constrained('tours', 'id');
            $table->foreignId('schedule_id')->constrained('tour_schedules', 'id');
            $table->integer('number_of_adults')->notNull()->default(1);
            $table->integer('number_of_children')->notNull()->default(0);
            $table->foreignId('guide_id')->nullable()->constrained('users', 'id');
        });

        // Hotel Bookings table
        Schema::create('hotel_bookings', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('booking_id')->constrained('bookings', 'id');
            $table->foreignId('hotel_id')->constrained('hotels', 'id');
            $table->foreignId('room_type_id')->constrained('room_types', 'id');
            $table->date('check_in_date')->notNull();
            $table->date('check_out_date')->notNull();
            $table->integer('number_of_rooms')->notNull()->default(1);
            $table->integer('number_of_guests')->notNull();
        });

        // Restaurant Bookings table
        Schema::create('restaurant_bookings', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('booking_id')->constrained('bookings', 'id');
            $table->foreignId('restaurant_id')->constrained('restaurants', 'id');
            $table->foreignId('table_id')->nullable()->constrained('restaurant_tables', 'id');
            $table->date('reservation_date')->notNull();
            $table->time('reservation_time')->notNull();
            $table->integer('number_of_guests')->notNull();
            $table->integer('duration')->default(120)->comment('Duration in minutes');
        });

        // Taxi Bookings table
        Schema::create('taxi_bookings', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('booking_id')->constrained('bookings', 'id');
            $table->foreignId('taxi_service_id')->constrained('taxi_services', 'id');
            $table->foreignId('vehicle_type_id')->constrained('vehicle_types', 'id');
            $table->foreignId('pickup_location_id')->constrained('locations', 'id');
            $table->foreignId('dropoff_location_id')->constrained('locations', 'id');
            $table->dateTime('pickup_date_time')->notNull();
            $table->decimal('estimated_distance', 10, 2)->nullable();
            $table->foreignId('driver_id')->nullable()->constrained('drivers', 'id');
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles', 'id');
        });

        // Package Bookings table
        Schema::create('package_bookings', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('booking_id')->constrained('bookings', 'id');
            $table->foreignId('package_id')->constrained('travel_packages', 'id');
            $table->date('start_date')->notNull();
            $table->integer('number_of_adults')->notNull()->default(1);
            $table->integer('number_of_children')->notNull()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_bookings');
        Schema::dropIfExists('taxi_bookings');
        Schema::dropIfExists('restaurant_bookings');
        Schema::dropIfExists('hotel_bookings');
        Schema::dropIfExists('tour_bookings');
        Schema::dropIfExists('bookings');
    }
};
