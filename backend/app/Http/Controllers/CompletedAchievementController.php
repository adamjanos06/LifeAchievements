<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompletedAchievementResource;
use App\Models\CompletedAchievement;
use Illuminate\Http\Request;

class CompletedAchievementController extends Controller
{
    public function index()
    {
        return CompletedAchievementResource::collection(CompletedAchievement::all());
    }

    public function show(CompletedAchievement $completedAchievement)
    {
        return new CompletedAchievementResource($completedAchievement);
    }

    public function store(Request $r)
    {
        $validated = $r->validate([
            'achievement_id' => 'required|exists:achievements,id',
            'notes' => 'nullable|string',
        ]);

        $completed = CompletedAchievement::create([
            'user_id' => $r->user()->id,
            'achievement_id' => $validated['achievement_id'],
            'completion_date' => now(),
            'notes' => $validated['notes'] ?? null,
        ]);

        return new CompletedAchievementResource($completed);
    }
}
