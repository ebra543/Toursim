<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomAvailability extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'RoomAvailability';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'AvailabilityID';

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
        'RoomTypeID',
        'Date',
        'AvailableRooms',
        'Price',
        'IsBlocked'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'Date' => 'date',
        'Price' => 'decimal:2',
        'IsBlocked' => 'boolean',
    ];

    /**
     * Get the room type that owns the availability.
     */
    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class, 'RoomTypeID', 'RoomTypeID');
    }
}