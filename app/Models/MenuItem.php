<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuItem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'MenuItems';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'ItemID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'CategoryID',
        'ItemName',
        'Description',
        'Price',
        'ImageURL',
        'IsVegetarian',
        'IsVegan',
        'IsGlutenFree',
        'Spiciness',
        'IsAvailable',
        'IsPopular'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'Price' => 'decimal:2',
        'IsVegetarian' => 'boolean',
        'IsVegan' => 'boolean',
        'IsGlutenFree' => 'boolean',
        'Spiciness' => 'integer',
        'IsAvailable' => 'boolean',
        'IsPopular' => 'boolean',
    ];

    /**
     * Get the category that owns the menu item.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(MenuCategory::class, 'CategoryID', 'CategoryID');
    }
}