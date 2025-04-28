<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourTranslation extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'TourTranslations';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'TranslationID';

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
        'LanguageCode',
        'TranslatedDescription'
    ];

    /**
     * Get the tour that owns the translation.
     */
    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class, 'TourID', 'TourID');
    }
}