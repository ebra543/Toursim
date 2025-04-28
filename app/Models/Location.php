<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Location extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Locations';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'LocationID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'LocationName',
        'CityID',
        'Description',
        'Latitude',
        'Longitude',
        'IsPopular'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'Latitude' => 'decimal:7',
        'Longitude' => 'decimal:7',
        'IsPopular' => 'boolean',
    ];

    /**
     * Get the city that owns the location.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'CityID', 'CityID');
    }
}