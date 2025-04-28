<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TourSchedule extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'TourSchedules';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'ScheduleID';

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
        'TourID',
        'StartDate',
        'EndDate',
        'StartTime',
        'AvailableSpots',
        'Price',
        'IsActive'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'StartDate' => 'date',
        'EndDate' => 'date',
        'StartTime' => 'datetime',
        'Price' => 'decimal:2',
        'IsActive' => 'boolean',
    ];

    /**
     * Get the tour that owns the schedule.
     */
    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class, 'TourID', 'TourID');
    }

    /**
     * Get the bookings for the schedule.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(TourBooking::class, 'ScheduleID', 'ScheduleID');
    }
}