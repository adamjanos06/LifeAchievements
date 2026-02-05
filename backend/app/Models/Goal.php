<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = [
        'user_id',
        'achievement_id',
    ];

    public $timestamps = true;

    public function achievement()
    {
        return $this->belongsTo(Achievement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
