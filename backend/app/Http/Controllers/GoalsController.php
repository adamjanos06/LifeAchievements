<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Goal;
use Illuminate\Http\Request;
use App\Services\BadgeService;

class GoalsController extends Controller
{
    public function index(Request $request)
    {
        $achievementIds = Goal::where('user_id', $request->user()->id)
            ->pluck('achievement_id');

        $achievements = Achievement::with('category')
            ->whereIn('id', $achievementIds)
            ->get();

        return response()->json([
            'data' => $achievements
        ]);
    }

    public function store(Request $request, Achievement $achievement)
    {
        $goal = Goal::firstOrCreate([
            'user_id' => $request->user()->id,
            'achievement_id' => $achievement->id,
        ]);

        $badge = BadgeService::checkGoalSetter($request->user());

        return response()->json([
            'message' => 'Goal added',
            'badge' => $badge
        ], 201);
    }

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

