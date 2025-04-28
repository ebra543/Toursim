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
        // taxi_services table
        Schema::create('taxi_services', function (Blueprint $table) {
            $table->id('id');
            $table->string('service_name')->notNull();
            $table->text('description')->nullable();
            $table->foreignId('location_id')->constrained('locations', 'id');
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->integer('total_ratings')->default(0);
            $table->string('logo_url')->nullable();
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('manager_id')->nullable()->constrained('users', 'id');
            $table->timestamps();
        });

        // vehicle_types table
        Schema::create('vehicle_types', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('taxi_service_id')->constrained('taxi_services', 'id');
            $table->string('type_name')->notNull();
            $table->text('description')->nullable();
            $table->integer('max_passengers')->notNull();
            $table->decimal('price_per_km', 10, 2)->notNull();
            $table->decimal('base_price', 10, 2)->notNull();
            $table->string('image_url')->nullable();
            $table->boolean('is_active')->default(true);
        });

        // vehicles table
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('taxi_service_id')->constrained('taxi_services', 'id');
            $table->foreignId('vehicle_type_id')->constrained('vehicle_types', 'id');
            $table->string('registration_number')->notNull();
            $table->string('model')->nullable();
            $table->integer('year')->nullable();
            $table->string('color')->nullable();
            $table->boolean('is_active')->default(true);
        });

        // drivers table
        Schema::create('drivers', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->foreignId('taxi_service_id')->constrained('taxi_services', 'id');
            $table->string('license_number')->notNull();
            $table->integer('experience_years')->nullable();
            $table->decimal('rating', 3, 2)->default(0);
            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Drivers');
        Schema::dropIfExists('Vehicles');
        Schema::dropIfExists('VehicleTypes');
        Schema::dropIfExists('TaxiServices');
    }
};
