<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageDestination extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'PackageDestinations';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'DestinationID';

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
        'PackageID',
        'LocationID',
        'DayNumber',
        'Description',
        'Duration'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'DayNumber' => 'integer',
    ];

    /**
     * Get the package that owns the destination.
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(TravelPackage::class, 'PackageID', 'PackageID');
    }

    /**
     * Get the location that owns the destination.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'LocationID', 'LocationID');
    }
}