<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Services\BadgeService;

class UserController extends Controller
{
    /**
     * Get current user's profile
     */

    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'user' => $user->load('badges'),
        ]);
    }

    /**
     * Mark profile as visited (for badge awarding)
     */
    public function profileVisited(Request $request)
    {
        $user = $request->user();

        $badge = BadgeService::checkProfileVisited($user);

        return response()->json([
            'badge' => $badge
        ]);
    }

    public function show(User $user)
    {
        $user->loadCount('completedAchievements');

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'bio' => $user->bio,
            'image' => $user->image,
            'xp' => $user->xp,
            'level_data' => $user->level_data,
            'favorite_category' => $user->favorite_category,
            'achievements_count' => $user->completed_achievements_count,
            'created_at' => $user->created_at,
        ]);
    }

    /**
     * Update logged-in user's profile
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:32',
            'bio' => 'nullable|string|max:300',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->bio = $validated['bio'] ?? null;

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }

            $path = $request->file('image')->store('pfp', 'public');
            $user->image = $path;
        }

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user,
        ]);
    }
    
}
