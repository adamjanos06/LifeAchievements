<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompletedAchievement extends Model
{
    protected $fillable = ['user_id','achievement_id','completion_date','notes'];


    public function user() { return $this->belongsTo(User::class); }
    public function achievement() { return $this->belongsTo(Achievement::class); }
}
