<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Experience Model
 * 
 * Represents work experience or education with multilingual support.
 * 
 * @property int $id
 * @property array $company Company or institution name in multiple languages (es, en)
 * @property array $role Job role or degree title in multiple languages (es, en)
 * @property array $period Time period in multiple languages (es, en)
 * @property array $location Location in multiple languages (es, en)
 * @property array $description Description in multiple languages (es, en)
 * @property string|null $logo Company or institution logo URL
 * @property string $type Type of experience: 'work' or 'education'
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Skill[] $skills
 */
class Experience extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = ['company', 'role', 'period', 'location', 'description', 'logo', 'type'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'company' => 'array',
        'role' => 'array',
        'period' => 'array',
        'location' => 'array',
        'description' => 'array',
    ];

    /**
     * Get the skills associated with this experience.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class);
    }
}
