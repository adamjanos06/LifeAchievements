<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\CompletedAchievement;
use Illuminate\Http\Request;
use App\Services\BadgeService;

class CompletedAchievementController extends Controller
{
    public function store(Request $request, Achievement $achievement)
    {
        CompletedAchievement::firstOrCreate(
            [
                'user_id' => $request->user()->id,
                'achievement_id' => $achievement->id,
            ],
            [
                'completion_date' => now(),
            ]
        );

        return response()->json([
            'message' => 'Achievement marked as completed'
        ]);
    }

    public function userCompleted(Request $request)
    {
        $user = $request->user();

        BadgeService::checkFirstStep($user);
        BadgeService::checkCategoryBadges($user);
    
        $completed = CompletedAchievement::with('achievement.category')
            ->where('user_id', $request->user()->id)
            ->get();
    
        return response()->json([
            'data' => $completed
        ]);
    }

}
