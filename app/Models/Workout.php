<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $fillable = [
        'user_id',
        'activity_name',
        'duration_minutes',
        'intensity',
        'calories_burned',
        'notes',
        'logged_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
