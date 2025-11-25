<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * User Model
 * 
 * Represents an authenticated user of the portfolio admin panel.
 * 
 * @property int $id
 * @property string $name User's full name
 * @property string $email User's email address
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password Hashed password
 * @property array|null $subtitle Subtitle in multiple languages (es, en)
 * @property array|null $description Description in multiple languages (es, en)
 * @property string|null $hero_image Hero image URL
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'subtitle',
        'description',
        'hero_image',
        'phone',
        'linkedin',
        'github',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'subtitle' => 'array',
            'description' => 'array',
        ];
    }
}
