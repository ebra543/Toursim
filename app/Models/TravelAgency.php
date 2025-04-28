<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TravelAgency extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'TravelAgencies';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'AgencyID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'AgencyName',
        'Description',
        'LocationID',
        'Website',
        'Phone',
        'Email',
        'IsActive',
        'ManagerID'
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
     * Get the location that owns the agency.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'LocationID', 'LocationID');
    }

    /**
     * Get the manager that owns the agency.
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ManagerID', 'UserID');
    }

    /**
     * Get the packages for the agency.
     */
    public function packages(): HasMany
    {
        return $this->hasMany(TravelPackage::class, 'AgencyID', 'AgencyID');
    }
}