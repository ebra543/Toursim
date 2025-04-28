<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class HotelAmenity extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'HotelAmenities';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'AmenityID';

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
        'AmenityName',
        'IconURL',
        'IsActive'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'IsActive' => 'boolean',
    ];

    /**
     * Get the hotels for the amenity.
     */
    public function hotels(): BelongsToMany
    {
        return $this->belongsToMany(
            Hotel::class,
            'HotelAmenityMapping',
            'AmenityID',
            'HotelID',
            'AmenityID',
            'HotelID'
        );
    }
}