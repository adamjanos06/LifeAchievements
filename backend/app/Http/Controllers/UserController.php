<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Badge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Get current user's profile
     */
    public function me(Request $request)
    {
        $user = $request->user();

        $badge = Badge::where('name', 'Profile Checked')->first();

        if ($badge && !$user->badges()->where('badge_id', $badge->id)->exists()) {
            $user->badges()->attach($badge->id, [
                'earned_at' => now()
            ]);
        }

        return response()->json(
            $user->load('badges')
        );
    }

    public function show(User $user)
    {
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'bio' => $user->bio,
            'image' => $user->image,
            'xp' => $user->xp,
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
            'bio' => 'nullable|string|max:32',
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
