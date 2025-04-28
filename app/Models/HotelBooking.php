<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotelBooking extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'HotelBookings';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'HotelBookingID';

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
        'HotelID',
        'RoomTypeID',
        'CheckInDate',
        'CheckOutDate',
        'NumberOfRooms',
        'NumberOfGuests'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'CheckInDate' => 'date',
        'CheckOutDate' => 'date',
    ];

    /**
     * Get the booking that owns the hotel booking.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'BookingID', 'BookingID');
    }

    /**
     * Get the hotel that owns the hotel booking.
     */
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class, 'HotelID', 'HotelID');
    }

    /**
     * Get the room type that owns the hotel booking.
     */
    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class, 'RoomTypeID', 'RoomTypeID');
    }
}