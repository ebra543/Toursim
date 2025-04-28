<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourImage extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'TourImages';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'ImageID';

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
        'ImageURL',
        'DisplayOrder',
        'Caption',
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
     * Get the tour that owns the image.
     */
    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class, 'TourID', 'TourID');
    }
}