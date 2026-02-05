<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Goal;
use Illuminate\Http\Request;

class GoalsController extends Controller
{
    // List current user's goals (as achievements)
    public function index(Request $request)
    {
        $achievementIds = Goal::where('user_id', $request->user()->id)
            ->pluck('achievement_id');

        $achievements = Achievement::whereIn('id', $achievementIds)->get();

        return response()->json([
            'data' => $achievements
        ]);
    }

    // Add a goal
    public function store(Request $request, Achievement $achievement)
    {
        Goal::firstOrCreate([
            'user_id' => $request->user()->id,
            'achievement_id' => $achievement->id,
        ]);

        return response()->json([
            'message' => 'Goal added'
        ], 201);
    }

    // Remove goal
    public function destroy(Request $request, Achievement $achievement)
    {
        Goal::where([
            'user_id' => $request->user()->id,
            'achievement_id' => $achievement->id,
        ])->delete();

        return response()->json([
            'message' => 'Goal removed'
        ]);
    }
}
