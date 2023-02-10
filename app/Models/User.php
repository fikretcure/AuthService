<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\RegCodeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Hash;

/**
 *
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, RegCodeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "name",
        "surname",
        "email",
        "password"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @var string
     */
    public static string $reg_code = "K";

    /**
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->name . ' ' . $this->surname;
    }

    /**
     * @return Attribute
     */
    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Hash::make($value),
        );
    }

    /**
     * @return Attribute
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn($value) => str()->title($value),
        );
    }

    /**
     * @return Attribute
     */
    protected function surname(): Attribute
    {
        return Attribute::make(
            set: fn($value) => str()->title($value),
        );
    }

}
