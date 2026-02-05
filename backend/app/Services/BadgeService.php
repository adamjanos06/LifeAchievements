<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\User;

class BadgeService
{
    public static function checkFirstStep(User $user)
    {
        $completedCount = $user->completedAchievements()->count();

        if ($completedCount >= 1) {

            $badge = Badge::where('name', 'First Step')->first();

            if ($badge && !$user->badges()->where('badge_id', $badge->id)->exists()) {
                $user->badges()->attach($badge->id, [
                    'earned_at' => now()
                ]);
            }
        }
    }
}
