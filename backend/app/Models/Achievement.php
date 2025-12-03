<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = ['category_id','name','description','xp','difficulty'];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function completions()
    {
        return $this->hasMany(CompletedAchievement::class);
    }
}
