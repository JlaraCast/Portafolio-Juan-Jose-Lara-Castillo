<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Skill[] $skills
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
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class);
    }
}
