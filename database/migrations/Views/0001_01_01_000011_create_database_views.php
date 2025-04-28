<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // tour_participants view
        DB::statement("CREATE VIEW tour_participants AS
            SELECT t.id AS tour_id, u.first_name, u.last_name
            FROM tours t
            JOIN tour_bookings tb ON t.id = tb.tour_id
            JOIN bookings b ON tb.booking_id = b.id
            JOIN users u ON b.user_id = u.id");

        // hotel_earnings view
        DB::statement("CREATE VIEW hotel_earnings AS
            SELECT h.id AS hotel_id, SUM(p.amount) AS total_earnings
            FROM hotels h
            JOIN hotel_bookings hb ON h.id = hb.hotel_id
            JOIN bookings b ON hb.booking_id = b.id
            JOIN payments p ON b.id = p.booking_id
            GROUP BY h.id");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS hotel_earnings");
        DB::statement("DROP VIEW IF EXISTS tour_participants");
    }
};
