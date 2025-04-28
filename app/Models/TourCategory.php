<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TourCategory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'TourCategories';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'CategoryID';

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
        'CategoryName',
        'Description',
        'ParentCategoryID',
        'IconURL',
        'DisplayOrder',
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
     * Get the parent category.
     */
    public function parentCategory(): BelongsTo
    {
        return $this->belongsTo(TourCategory::class, 'ParentCategoryID', 'CategoryID');
    }

    /**
     * Get the child categories.
     */
    public function childCategories(): HasMany
    {
        return $this->hasMany(TourCategory::class, 'ParentCategoryID', 'CategoryID');
    }

    /**
     * Get the tours for the category.
     */
    public function tours(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class, 'TourCategoryMapping', 'CategoryID', 'TourID', 'CategoryID', 'TourID');
    }
}