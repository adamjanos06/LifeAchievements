<?php

namespace App\Http\Controllers;

use App\Http\Resources\AchievementResource;
use App\Models\Achievement;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function index()
    {
        return AchievementResource::collection(Achievement::all());
    }

    public function show(Achievement $achievement)
    {
        return new AchievementResource($achievement);
    }

    public function store(Request $r)
    {
        $validated = $r->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'xp' => 'required|integer|min:0',
            'difficulty' => 'required|in:easy,medium,hard',
        ]);

        $achievement = Achievement::create($validated);

        return new AchievementResource($achievement);
    }
}
