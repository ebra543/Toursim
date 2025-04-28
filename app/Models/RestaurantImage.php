<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RestaurantImage extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'RestaurantImages';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'ImageID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'RestaurantID',
        'ImageURL',
        'Caption',
        'DisplayOrder',
        'IsActive'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'DisplayOrder' => 'integer',
        'IsActive' => 'boolean',
    ];

    /**
     * Get the restaurant that owns the image.
     */
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class, 'RestaurantID', 'RestaurantID');
    }
}