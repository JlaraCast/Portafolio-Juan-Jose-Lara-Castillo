<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Skill Model
 * 
 * Represents a technical skill or technology.
 * 
 * @property int $id
 * @property string $name Skill name
 * @property string|null $icon SVG or icon HTML code
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Project[] $projects
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Experience[] $experiences
 */
class Skill extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = ['name', 'icon'];

    /**
     * Get the projects associated with this skill.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }

    /**
     * Get the experiences associated with this skill.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function experiences(): BelongsToMany
    {
        return $this->belongsToMany(Experience::class);
    }
}
