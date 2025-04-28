<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurant extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Restaurants';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'RestaurantID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'RestaurantName',
        'Description',
        'LocationID',
        'Cuisine',
        'PriceRange',
        'OpeningTime',
        'ClosingTime',
        'AverageRating',
        'TotalRatings',
        'MainImageURL',
        'Website',
        'Phone',
        'Email',
        'HasReservation',
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
        'OpeningTime' => 'datetime',
        'ClosingTime' => 'datetime',
        'AverageRating' => 'decimal:2',
        'HasReservation' => 'boolean',
        'IsActive' => 'boolean',
        'IsFeatured' => 'boolean',
    ];

    /**
     * Get the location that owns the restaurant.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'LocationID', 'LocationID');
    }

    /**
     * Get the manager that owns the restaurant.
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ManagerID', 'UserID');
    }

    /**
     * Get the images for the restaurant.
     */
    public function images(): HasMany
    {
        return $this->hasMany(RestaurantImage::class, 'RestaurantID', 'RestaurantID');
    }

    /**
     * Get the menu categories for the restaurant.
     */
    public function menuCategories(): HasMany
    {
        return $this->hasMany(MenuCategory::class, 'RestaurantID', 'RestaurantID');
    }

    /**
     * Get the tables for the restaurant.
     */
    public function tables(): HasMany
    {
        return $this->hasMany(RestaurantTable::class, 'RestaurantID', 'RestaurantID');
    }

    /**
     * Get the bookings for the restaurant.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(RestaurantBooking::class, 'RestaurantID', 'RestaurantID');
    }
}