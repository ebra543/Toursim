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
        // Payments table
        Schema::create('payments', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('booking_id')->constrained('bookings', 'id');
            $table->string('payment_reference')->unique()->notNull();
            $table->decimal('amount', 10, 2)->notNull();
            $table->dateTime('payment_date')->default(now());
            $table->enum('payment_method', ['Credit Card', 'PayPal', 'Bank Transfer']);
            $table->string('transaction_id')->nullable();
            $table->enum('status', ['Pending', 'Success', 'Failed', 'Refunded'])->default('Pending');
            $table->text('gateway_response')->nullable();
            $table->decimal('refund_amount', 10, 2)->default(0);
            $table->dateTime('refund_date')->nullable();
            $table->text('refund_reason')->nullable();
        });

        // Ratings table
        Schema::create('ratings', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->foreignId('booking_id')->constrained('bookings', 'id');
            $table->enum('rating_type', ['Tour', 'Hotel', 'Taxi', 'Restaurant', 'Package', 'Guide', 'Driver'])->notNull();
            $table->integer('entity_id')->notNull()->comment('tour_id, hotel_id, taxi_service_id, restaurant_id, package_id, guide_id, driver_id');
            $table->integer('rating')->notNull();
            $table->text('comment')->nullable();
            $table->dateTime('rating_date')->default(now());
            $table->boolean('is_visible')->default(true);
            $table->text('admin_response')->nullable();
            $table->unique(['user_id', 'booking_id', 'rating_type']);
        });

        // Feedback table
        Schema::create('feedback', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('user_id')->nullable()->constrained('users', 'id');
            $table->text('feedback_text')->notNull();
            $table->dateTime('feedback_date')->default(now());
            $table->enum('feedback_type', ['App', 'Service', 'Other']);
            $table->enum('status', ['Unread', 'Read', 'Responded'])->default('Unread');
            $table->text('response_text')->nullable();
            $table->dateTime('response_date')->nullable();
            $table->foreignId('responded_by')->nullable()->constrained('users', 'id');
        });

        // Promotions table
        Schema::create('promotions', function (Blueprint $table) {
            $table->id('id');
            $table->string('promotion_code')->unique()->notNull();
            $table->text('description')->nullable();
            $table->enum('discount_type', ['Percentage', 'Fixed Amount']);
            $table->decimal('discount_value', 10, 2)->notNull();
            $table->decimal('minimum_purchase', 10, 2)->default(0);
            $table->dateTime('start_date')->notNull();
            $table->dateTime('end_date')->notNull();
            $table->integer('usage_limit')->nullable();
            $table->integer('current_usage')->default(0);
            $table->enum('applicable_type', ['All', 'Tour', 'Hotel', 'Taxi', 'Restaurant', 'Package'])->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->constrained('users', 'id');
            $table->dateTime('created_at')->default(now());
        });

        // Wishlist table
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->enum('item_type', ['Tour', 'Hotel', 'Restaurant', 'Package']);
            $table->integer('item_id')->notNull();
            $table->dateTime('added_date')->default(now());
            $table->unique(['user_id', 'item_type', 'item_id']);
        });

        // Notifications table
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->string('title')->notNull();
            $table->text('message')->notNull();
            $table->enum('notification_type', ['Payment', 'Booking', 'Tour', 'System'])->notNull();
            $table->integer('reference_id')->nullable();
            $table->boolean('is_read')->default(false);
            $table->dateTime('created_at')->default(now());
        });


        // Audit Log table
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('user_id')->nullable()->constrained('users', 'id');
            $table->string('entity_type')->notNull();
            $table->integer('entity_id')->notNull();
            $table->string('action')->notNull();
            $table->text('old_values')->nullable();
            $table->text('new_values')->nullable();
            $table->string('ip_address')->nullable();
            $table->dateTime('log_date')->default(now());
        });

        // User Ranks table
        Schema::create('user_ranks', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->string('rank_name')->nullable();
            $table->integer('points_earned')->nullable();
        });

        // Tour Translations table
        Schema::create('tour_translations', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('tour_id')->constrained('tours', 'id');
            $table->string('language_code');
            $table->text('translated_description');
        });

        // Partnerships table
        Schema::create('partnerships', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('guide_id')->nullable()->constrained('users', 'id');
            $table->foreignId('hotel_id')->nullable()->constrained('hotels', 'id');
            $table->foreignId('restaurant_id')->nullable()->constrained('restaurants', 'id');
            $table->foreignId('taxi_service_id')->nullable()->constrained('taxi_services', 'id');
            $table->decimal('discount_percentage', 5, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partnerships');
        Schema::dropIfExists('tour_translations');
        Schema::dropIfExists('user_ranks');
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('user_sessions');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('wishlists');
        Schema::dropIfExists('promotions');
        Schema::dropIfExists('feedback');
        Schema::dropIfExists('ratings');
        Schema::dropIfExists('payments');
    }
};
