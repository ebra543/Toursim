<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Hotel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Hotels';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'HotelID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'HotelName',
        'Description',
        'LocationID',
        'StarRating',
        'CheckInTime',
        'CheckOutTime',
        'AverageRating',
        'TotalRatings',
        'MainImageURL',
        'Website',
        'Phone',
        'Email',
        'IsActive',
        'IsFeatured',
        'ManagerID'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'CheckInTime' => 'datetime',
        'CheckOutTime' => 'datetime',
        'AverageRating' => 'decimal:2',
        'IsActive' => 'boolean',
        'IsFeatured' => 'boolean',
    ];

    /**
     * Get the location that owns the hotel.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'LocationID', 'LocationID');
    }

    /**
     * Get the manager that owns the hotel.
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ManagerID', 'UserID');
    }

    /**
     * Get the images for the hotel.
     */
    public function images(): HasMany
    {
        return $this->hasMany(HotelImage::class, 'HotelID', 'HotelID');
    }

    /**
     * Get the room types for the hotel.
     */
    public function roomTypes(): HasMany
    {
        return $this->hasMany(RoomType::class, 'HotelID', 'HotelID');
    }

    /**
     * Get the amenities for the hotel.
     */
    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(
            HotelAmenity::class,
            'HotelAmenityMapping',
            'HotelID',
            'AmenityID',
            'HotelID',
            'AmenityID'
        );
    }

    /**
     * Get the bookings for the hotel.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(HotelBooking::class, 'HotelID', 'HotelID');
    }
}