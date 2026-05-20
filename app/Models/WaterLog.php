<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaterLog extends Model
{
    protected $fillable = [
        'user_id',
        'amount_ml',
        'logged_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
