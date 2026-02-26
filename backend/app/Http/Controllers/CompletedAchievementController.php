<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\CompletedAchievement;
use Illuminate\Http\Request;
use App\Services\BadgeService;
use App\Models\Goal;

class CompletedAchievementController extends Controller
{
public function store(Request $request, Achievement $achievement)
{
    $user = $request->user();

    if ($achievement->repeatable) {
        // For repeatable achievements, increment completion count
        $completed = CompletedAchievement::firstOrCreate(
            [
                'user_id' => $user->id,
                'achievement_id' => $achievement->id,
            ],
            [
                'completion_date' => now(),
                'completions' => 1,
            ]
        );

        // If record already exists, increment completions
        if (!$completed->wasRecentlyCreated) {
            $completed->increment('completions');
        }
    } else {
        // For non-repeatable achievements, create once
        CompletedAchievement::firstOrCreate(
            [
                'user_id' => $user->id,
                'achievement_id' => $achievement->id,
            ],
            [
                'completion_date' => now(),
                'completions' => 1,
            ]
        );
    }

    // Remove from goals if exists
    Goal::where([
        'user_id' => $request->user()->id,
        'achievement_id' => $achievement->id
    ])->delete();

    $user->xp += $achievement->xp;
    $user->save();

    return response()->json([
        'message' => 'Achievement marked as completed',
        'xp' => $user->xp
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
