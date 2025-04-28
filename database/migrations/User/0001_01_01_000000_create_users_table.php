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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique()->notNull();
            $table->string('password_hash')->notNull();
            $table->string('password_salt')->notNull();
            $table->string('first_name')->notNull();
            $table->string('last_name')->notNull();
            $table->string('phone')->nullable();
            $table->integer('country_id')->nullable();

            $table->enum('user_type', ['client', 'admin', 'guide', 'hotel_manager', 'taxi_agent', 'restaurant_manager', 'travel_agency_rep'])
                ->notNull()->comment('1=Client, 2=Admin, 3=Guide, 4=Hotel Manager, 5=Taxi Agent, 6=Restaurant Manager, 7=Travel Agency Rep');
            $table->dateTime('registration_date')->default(now());
            $table->timestamp('last_login_date')->nullable();
            $table->integer('status')->default(1)->comment('1=Active, 0=Inactive');
            $table->string('profile_image_url')->nullable();
            $table->string('preferred_language')->default('en');
            $table->boolean('is_email_verified')->default(false);
            $table->boolean('is_phone_verified')->default(false);
            $table->rememberToken();
            $table->timestamps();

            // Add index for user_type
            $table->index('user_type', 'idx_user_type');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('user_sessions', function (Blueprint $table) {
            $table->id(); // Defaults to 'id' column
            $table->foreignId('user_id')->constrained(); // Assumes 'users' table with 'id'
            $table->string('session_token'); // More descriptive than 'token'
            $table->string('ip_address')->nullable();
            $table->string('device_info')->nullable();
            $table->dateTime('login_time')->useCurrent(); // DATETIME with explicit default
            $table->dateTime('logout_time')->nullable();
            $table->boolean('is_active')->default(true);
        });


        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('user_sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
