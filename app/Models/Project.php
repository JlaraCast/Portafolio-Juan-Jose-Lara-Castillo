<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * Project Model
 *
 * Represents a portfolio project with multilingual support.
 *
 * @property int $id
 * @property array $title Title in multiple languages (es, en)
 * @property array $description Description in multiple languages (es, en)
 * @property string|null $image_url Project image URL
 * @property string|null $github_url GitHub repository URL
 * @property string|null $live_url Live project URL
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Collection|Skill[] $skills
 */
class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = ['title', 'description', 'image_url', 'github_url', 'live_url'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'title' => 'array',
        'description' => 'array',
    ];

    /**
     * Get the skills associated with this project.
     */
    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class);
    }
}
