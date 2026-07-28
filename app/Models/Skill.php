<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * Skill Model
 *
 * Represents a technical skill or technology.
 *
 * @property int $id
 * @property string $name Skill name
 * @property string|null $icon SVG or icon HTML code
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Collection|Project[] $projects
 * @property-read Collection|Experience[] $experiences
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
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }

    /**
     * Get the experiences associated with this skill.
     */
    public function experiences(): BelongsToMany
    {
        return $this->belongsToMany(Experience::class);
    }
}
