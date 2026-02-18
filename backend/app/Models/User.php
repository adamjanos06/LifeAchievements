<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Services\ProgressionService;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'xp',
        'bio',
        'image'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function completedAchievements()
    {
        return $this->hasMany(\App\Models\CompletedAchievement::class);
    }

    public function badges()
    {
        return $this->belongsToMany(\App\Models\Badge::class)
                    ->withPivot('earned_at')
                    ->withTimestamps();
    }

    public function sentFriendRequests()
    {
        return $this->hasMany(friend_request::class, 'sender_id');
    }

    public function receivedFriendRequests()
    {
        return $this->hasMany(friend_request::class, 'receiver_id');
    }

    public function friends()
    {
        return User::whereIn('id', function ($query) {
            $query->select('receiver_id')
                  ->from('friend_requests')
                  ->where('sender_id', $this->id)
                  ->where('status', 'accepted');
        })->orWhereIn('id', function ($query) {
            $query->select('sender_id')
                  ->from('friend_requests')
                  ->where('receiver_id', $this->id)
                  ->where('status', 'accepted');
        });
    }

    public function getLevelDataAttribute()
    {
        return ProgressionService::calculateLevel($this->xp);
    }
    
    protected $appends = [
    'level_data',
    ];
}
