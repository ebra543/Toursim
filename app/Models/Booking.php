<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Bookings';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'BookingID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'BookingReference',
        'UserID',
        'BookingType',
        'BookingDate',
        'Status',
        'TotalPrice',
        'DiscountAmount',
        'PaymentStatus',
        'SpecialRequests',
        'CancellationReason',
        'LastUpdated'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'BookingDate' => 'datetime',
        'LastUpdated' => 'datetime',
        'TotalPrice' => 'decimal:2',
        'DiscountAmount' => 'decimal:2',
    ];

    /**
     * Get the user that owns the booking.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }

    /**
     * Get the tour booking for the booking.
     */
    public function tourBooking(): HasOne
    {
        return $this->hasOne(TourBooking::class, 'BookingID', 'BookingID');
    }

    /**
     * Get the hotel booking for the booking.
     */
    public function hotelBooking(): HasOne
    {
        return $this->hasOne(HotelBooking::class, 'BookingID', 'BookingID');
    }

    /**
     * Get the restaurant booking for the booking.
     */
    public function restaurantBooking(): HasOne
    {
        return $this->hasOne(RestaurantBooking::class, 'BookingID', 'BookingID');
    }

    /**
     * Get the taxi booking for the booking.
     */
    public function taxiBooking(): HasOne
    {
        return $this->hasOne(TaxiBooking::class, 'BookingID', 'BookingID');
    }

    /**
     * Get the package booking for the booking.
     */
    public function packageBooking(): HasOne
    {
        return $this->hasOne(PackageBooking::class, 'BookingID', 'BookingID');
    }

    /**
     * Get the payments for the booking.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'BookingID', 'BookingID');
    }

    /**
     * Get the ratings for the booking.
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class, 'BookingID', 'BookingID');
    }
}