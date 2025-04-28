<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TravelPackage extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'TravelPackages';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'PackageID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'AgencyID',
        'PackageName',
        'Description',
        'DurationDays',
        'BasePrice',
        'DiscountPercentage',
        'MaxParticipants',
        'AverageRating',
        'TotalRatings',
        'MainImageURL',
        'IsActive',
        'IsFeatured'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'DurationDays' => 'integer',
        'BasePrice' => 'decimal:2',
        'DiscountPercentage' => 'decimal:2',
        'MaxParticipants' => 'integer',
        'AverageRating' => 'decimal:2',
        'TotalRatings' => 'integer',
        'IsActive' => 'boolean',
        'IsFeatured' => 'boolean',
    ];

    /**
     * Get the agency that owns the package.
     */
    public function agency(): BelongsTo
    {
        return $this->belongsTo(TravelAgency::class, 'AgencyID', 'AgencyID');
    }

    /**
     * Get the destinations for the package.
     */
    public function destinations(): HasMany
    {
        return $this->hasMany(PackageDestination::class, 'PackageID', 'PackageID');
    }

    /**
     * Get the inclusions for the package.
     */
    public function inclusions(): HasMany
    {
        return $this->hasMany(PackageInclusion::class, 'PackageID', 'PackageID');
    }

    /**
     * Get the bookings for the package.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(PackageBooking::class, 'PackageID', 'PackageID');
    }
}