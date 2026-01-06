<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\CompletedAchievement;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function index(Request $request) {
        $user = $request->user('sanctum');
        
        $completedIds = $user
            ? CompletedAchievement::where('user_id', $user->id)
                ->pluck('achievement_id')
                ->toArray()
            : [];
        
        $achievements = Achievement::all()->map(function ($achievement) use ($completedIds) {
            return [
                'id' => $achievement->id,
                'category_id' => $achievement->category_id,
                'name' => $achievement->name,
                'description' => $achievement->description,
                'xp' => $achievement->xp,
                'difficulty' => $achievement->difficulty,
                'completed' => in_array($achievement->id, $completedIds),
            ];
        });
    
        return response()->json([
            'data' => $achievements
        ]);
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

        return response()->json([
            'message' => 'Completed'
        ]);
    }

    // My achievements
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
