<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = ['company', 'role', 'period', 'location', 'description', 'logo', 'type'];

    protected $casts = [
        'company' => 'array',
        'role' => 'array',
        'period' => 'array',
        'location' => 'array',
        'description' => 'array',
    ];
}
