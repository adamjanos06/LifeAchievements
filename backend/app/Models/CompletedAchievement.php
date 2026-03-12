<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompletedAchievement extends Model
{
    protected $fillable = [
        'user_id',
        'achievement_id',
        'completion_date',
        'notes',
        // tracking number of times a repeatable achievement was done
        'completions',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function achievement() {
        return $this->belongsTo(Achievement::class);
    }
}
