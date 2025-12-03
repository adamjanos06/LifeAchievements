<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    protected $fillable = ['name','description','requirement_text'];


    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('earned_at')->withTimestamps();
    }
}
