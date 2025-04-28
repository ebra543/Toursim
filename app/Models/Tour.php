<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tour extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Tours';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'TourID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'TourName',
        'Description',
        'ShortDescription',
        'LocationID',
        'DurationHours',
        'DurationDays',
        'BasePrice',
        'DiscountPercentage',
        'MaxCapacity',
        'MinParticipants',
        'DifficultyLevel',
        'AverageRating',
        'TotalRatings',
        'MainImageURL',
        'IsActive',
        'IsFeatured',
        'CreatedBy'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'DurationHours' => 'decimal:2',
        'BasePrice' => 'decimal:2',
        'DiscountPercentage' => 'decimal:2',
        'AverageRating' => 'decimal:2',
        'IsActive' => 'boolean',
        'IsFeatured' => 'boolean',
    ];

    /**
     * Get the location that owns the tour.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'LocationID', 'LocationID');
    }

    /**
     * Get the user that created the tour.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'CreatedBy', 'UserID');
    }

    /**
     * Get the images for the tour.
     */
    public function images(): HasMany
    {
        return $this->hasMany(TourImage::class, 'TourID', 'TourID');
    }

    /**
     * Get the schedules for the tour.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(TourSchedule::class, 'TourID', 'TourID');
    }

    /**
     * Get the translations for the tour.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(TourTranslation::class, 'TourID', 'TourID');
    }

    /**
     * Get the categories for the tour.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            TourCategory::class,
            'TourCategoryMapping',
            'TourID',
            'CategoryID',
            'TourID',
            'CategoryID'
        );
    }

    /**
     * Get the bookings for the tour.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(TourBooking::class, 'TourID', 'TourID');
    }
}