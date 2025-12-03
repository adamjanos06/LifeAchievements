<?php

namespace App\Http\Controllers;

use App\Http\Resources\BadgeResource;
use App\Models\Badge;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    public function index()
    {
        return BadgeResource::collection(Badge::all());
    }

    public function show(Badge $badge)
    {
        return new BadgeResource($badge);
    }

    public function store(Request $r)
    {
        $validated = $r->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'requirement_text' => 'nullable|string',
        ]);

        $badge = Badge::create($validated);

        return new BadgeResource($badge);
    }
}
