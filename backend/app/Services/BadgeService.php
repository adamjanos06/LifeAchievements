<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\User;
use App\Models\Category;
use App\Models\CompletedAchievement;

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
    public static function checkCategoryBadges(User $user)
    {
        // Összes kategória
        $categories = Category::all();

        foreach ($categories as $category) {

            $completedCount = CompletedAchievement::where('user_id', $user->id)
                ->whereHas('achievement', function ($query) use ($category) {
                    $query->where('category_id', $category->id);
                })
                ->count();

            if ($completedCount >= 10) {

                $badgeName = $category->name . ' Master';

                $badge = Badge::where('name', $badgeName)->first();

                if ($badge && !$user->badges()->where('badge_id', $badge->id)->exists()) {
                    $user->badges()->attach($badge->id, [
                        'earned_at' => now()
                    ]);
                }
            }
        }
    }
    
    public static function checkAllBadges(User $user)
    {
        self::checkFirstStep($user);
        self::checkCategoryBadges($user);
    }
}
