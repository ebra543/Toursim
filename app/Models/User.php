<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'UserID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Email',
        'PasswordHash',
        'PasswordSalt',
        'FirstName',
        'LastName',
        'Phone',
        'CountryID',
        'UserType',
        'RegistrationDate',
        'LastLoginDate',
        'Status',
        'ProfileImageURL',
        'PreferredLanguage',
        'IsEmailVerified',
        'IsPhoneVerified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'PasswordHash',
        'PasswordSalt',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'RegistrationDate' => 'datetime',
        'LastLoginDate' => 'datetime',
        'IsEmailVerified' => 'boolean',
        'IsPhoneVerified' => 'boolean',
    ];

    /**
     * Get the country that owns the user.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'CountryID', 'CountryID');
    }

    /**
     * Get the tours created by the user.
     */
    public function createdTours(): HasMany
    {
        return $this->hasMany(Tour::class, 'CreatedBy', 'UserID');
    }

    /**
     * Get the bookings for the user.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'UserID', 'UserID');
    }
}
