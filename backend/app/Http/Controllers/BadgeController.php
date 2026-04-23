<?php

namespace App\Http\Controllers;

use App\Http\Resources\BadgeResource;
use App\Models\Badge;
use Illuminate\Http\Request;
use App\Services\BadgeService;

class BadgeController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user('sanctum');
        $badges = Badge::all();

        if ($user) {
            $earnedBadgeIds = $user->badges()->pluck('badge_id')->toArray();
            $badges->transform(function ($badge) use ($earnedBadgeIds) {
                $badge->earned = in_array($badge->id, $earnedBadgeIds, true);
                return $badge;
            });
        }

        return BadgeResource::collection($badges);
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

    public function darkSide(Request $request)
    {
        $badge = BadgeService::checkDarkSide($request->user());

        return response()->json([
            'badge' => $badge
        ]);
    }
}
