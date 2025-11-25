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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['start_date', 'end_date', 'is_current'];

    /**
     * Get the skills associated with this experience.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class);
    }

    /**
     * Get the start date from the period.
     *
     * @return string|null
     */
    public function getStartDateAttribute(): ?string
    {
        if (empty($this->period['en'])) {
            return null;
        }

        $parts = explode('-', $this->period['en']);
        $start = trim($parts[0]);

        try {
            return \Carbon\Carbon::createFromFormat('F Y', $start)->format('Y-m');
        } catch (\Exception $e) {
            try {
                return \Carbon\Carbon::createFromFormat('M Y', $start)->format('Y-m');
            } catch (\Exception $e) {
                return null;
            }
        }
    }

    /**
     * Get the end date from the period.
     *
     * @return string|null
     */
    public function getEndDateAttribute(): ?string
    {
        if (empty($this->period['en'])) {
            return null;
        }

        $parts = explode('-', $this->period['en']);
        
        if (count($parts) < 2) {
            return null;
        }

        $end = trim($parts[1]);

        if (stripos($end, 'Present') !== false || stripos($end, 'Current') !== false) {
            return null;
        }

        try {
            return \Carbon\Carbon::createFromFormat('F Y', $end)->format('Y-m');
        } catch (\Exception $e) {
            try {
                return \Carbon\Carbon::createFromFormat('M Y', $end)->format('Y-m');
            } catch (\Exception $e) {
                return null;
            }
        }
    }

    /**
     * Check if the experience is current.
     *
     * @return bool
     */
    public function getIsCurrentAttribute(): bool
    {
        if (empty($this->period['en'])) {
            return false;
        }
        return stripos($this->period['en'], 'Present') !== false;
    }
}
