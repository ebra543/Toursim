<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuCategory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'MenuCategories';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'CategoryID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'RestaurantID',
        'CategoryName',
        'Description',
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
     * Get the restaurant that owns the menu category.
     */
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class, 'RestaurantID', 'RestaurantID');
    }

    /**
     * Get the menu items for the category.
     */
    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'CategoryID', 'CategoryID');
    }
}