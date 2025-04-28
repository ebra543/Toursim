<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RestaurantBooking extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'RestaurantBookings';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'RestaurantBookingID';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'BookingID',
        'RestaurantID',
        'TableID',
        'ReservationDate',
        'ReservationTime',
        'NumberOfGuests',
        'Duration'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'ReservationDate' => 'date',
        'ReservationTime' => 'datetime',
    ];

    /**
     * Get the booking that owns the restaurant booking.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'BookingID', 'BookingID');
    }

    /**
     * Get the restaurant that owns the restaurant booking.
     */
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class, 'RestaurantID', 'RestaurantID');
    }

    /**
     * Get the table that owns the restaurant booking.
     */
    public function table(): BelongsTo
    {
        return $this->belongsTo(RestaurantTable::class, 'TableID', 'TableID');
    }
}