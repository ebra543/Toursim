<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageInclusion extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'PackageInclusions';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'InclusionID';

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
        'InclusionType',
        'Description',
        'IsHighlighted'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'InclusionType' => 'integer',
        'IsHighlighted' => 'boolean',
    ];

    /**
     * Get the package that owns the inclusion.
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(TravelPackage::class, 'PackageID', 'PackageID');
    }
}