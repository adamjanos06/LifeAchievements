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

            if (!$completed->wasRecentlyCreated) {
                $completed->increment('completions');
                $completed->completion_date = now();
                $completed->save();
            }
        } else {
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

        Goal::where([
            'user_id' => $user->id,
            'achievement_id' => $achievement->id
        ])->delete();

        $user->xp += $achievement->xp;
        $user->save();

        $badge = BadgeService::checkFirstStep($user);

        if (!$badge) {
            $badge = BadgeService::checkCategoryBadges($user);
        }

        return response()->json([
            'message' => 'Achievement marked as completed',
            'xp' => $user->xp,
            'badge' => $badge
        ]);
    }

    public function userCompleted(Request $request)
    {
        $user = $request->user();

        $badge = BadgeService::checkFirstStep($user);

        if (!$badge) {
            $badge = BadgeService::checkCategoryBadges($user);
        }

        $completed = CompletedAchievement::with('achievement.category')
            ->where('user_id', $user->id)
            ->orderByDesc('completion_date')
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'data' => $completed
        ]);
    }
}