<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoomType extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'RoomTypes';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'RoomTypeID';

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
        'HotelID',
        'RoomTypeName',
        'Description',
        'MaxOccupancy',
        'BasePrice',
        'DiscountPercentage',
        'Size',
        'BedType',
        'ImageURL',
        'IsActive'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'BasePrice' => 'decimal:2',
        'DiscountPercentage' => 'decimal:2',
        'IsActive' => 'boolean',
    ];

    /**
     * Get the hotel that owns the room type.
     */
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class, 'HotelID', 'HotelID');
    }

    /**
     * Get the availability for the room type.
     */
    public function availability(): HasMany
    {
        return $this->hasMany(RoomAvailability::class, 'RoomTypeID', 'RoomTypeID');
    }

    /**
     * Get the bookings for the room type.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(HotelBooking::class, 'RoomTypeID', 'RoomTypeID');
    }
}