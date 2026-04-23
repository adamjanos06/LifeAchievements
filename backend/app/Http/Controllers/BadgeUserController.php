<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use Illuminate\Http\Request;

class BadgeUserController extends Controller
{
    // List earned badges
    public function index(Request $request)
    {
        return response()->json([
            'data' => $request->user()->badges()
                ->withPivot('earned_at')
                ->get()
        ]);
    }

    // Earn badge
    public function store(Request $request, Badge $badge)
    {
        $request->user()->badges()->syncWithoutDetaching([
            $badge->id
        ]);

        return response()->json([
            'message' => 'Badge earned'
        ], 201);
    }
}
