<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\CompletedAchievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AchievementController extends Controller
{
    public function index(Request $request) {
        $user = $request->user('sanctum');

        $completionCounts = [];
        if ($user) {
            $completionCounts = CompletedAchievement::where('user_id', $user->id)
                ->select('achievement_id', DB::raw('COALESCE(SUM(completions),0) as count'))
                ->groupBy('achievement_id')
                ->pluck('count', 'achievement_id')
                ->toArray();
        }

        $achievements = Achievement::all()->map(function ($achievement) use ($completionCounts) {
            $times = $completionCounts[$achievement->id] ?? 0;

            return [
                'id' => $achievement->id,
                'category_id' => $achievement->category_id,
                'name' => $achievement->name,
                'description' => $achievement->description,
                'xp' => $achievement->xp,
                'difficulty' => $achievement->difficulty,
                'repeatable' => $achievement->repeatable,
                'completions' => $times,
                'completed' => $times > 0,
            ];
        });
    
        return response()->json([
            'data' => $achievements
        ]);
    }

    public function myAchievements(Request $request)
    {
        $achievementIds = CompletedAchievement::where(
            'user_id',
            $request->user()->id
        )->pluck('achievement_id');

        $achievements = Achievement::whereIn('id', $achievementIds)->get();

        return response()->json([
            'data' => $achievements
        ]);
    }
}
