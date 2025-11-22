<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = ['name', 'proficiency', 'icon'];

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public function experiences()
    {
        return $this->belongsToMany(Experience::class);
    }
}
