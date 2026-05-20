<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FitnessIdea extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category',
        'intensity_level',
        'equipment_needed',
        'duration_est',
        'calories_burned_est',
        'instructions',
    ];

    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_ideas');
    }
}
