<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourBooking extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'TourBookings';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'TourBookingID';

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
        'BookingID',
        'TourID',
        'ScheduleID',
        'NumberOfAdults',
        'NumberOfChildren',
        'GuideID'
    ];

    /**
     * Get the booking that owns the tour booking.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'BookingID', 'BookingID');
    }

    /**
     * Get the tour that owns the tour booking.
     */
    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class, 'TourID', 'TourID');
    }

    /**
     * Get the schedule that owns the tour booking.
     */
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(TourSchedule::class, 'ScheduleID', 'ScheduleID');
    }

    /**
     * Get the guide that owns the tour booking.
     */
    public function guide(): BelongsTo
    {
        return $this->belongsTo(User::class, 'GuideID', 'UserID');
    }
}