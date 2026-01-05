<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\CompletedAchievement;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $completedIds = CompletedAchievement::where('user_id', $user->id)
            ->pluck('achievement_id');

        $achievements = Achievement::all()->map(function ($a) use ($completedIds) {
            $a->completed = $completedIds->contains($a->id);
            return $a;
        });

        return response()->json(['data' => $achievements]);
    }

    // Mark as completed
    public function complete(Request $request, $id)
    {
        CompletedAchievement::firstOrCreate(
            [
                'user_id' => $request->user()->id,
                'achievement_id' => $id,
            ],
            [
                'completion_date' => now(),
            ]
        );

        return response()->json(['message' => 'Completed']);
    }

    // My achievements
    public function myAchievements(Request $request)
    {
        $achievementIds = CompletedAchievement::where(
            'user_id',
            $request->user()->id
        )->pluck('achievement_id');

        $achievements = Achievement::whereIn('id', $achievementIds)->get();

        return response()->json(['data' => $achievements]);
    }
}
