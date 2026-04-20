<?php

namespace App\Http\Controllers;

use App\Models\friend_request;
use App\Models\User;
use App\Services\BadgeService;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    // List friends
    public function index(Request $request)
    {
        $user = $request->user();

        $acceptedRequests = friend_request::with(['sender', 'receiver'])
            ->where('status', 'accepted')
            ->where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->orWhere('receiver_id', $user->id);
            })
            ->get();

        $friends = $acceptedRequests->map(function ($friendRequest) use ($user) {
            $friend = $friendRequest->sender_id === $user->id
                ? $friendRequest->receiver
                : $friendRequest->sender;

            $friend->accepted_at = $friendRequest->created_at;

            return $friend;
        });

        return response()->json([
            'data' => $friends
        ]);
    }

    // Send friend request
    public function send(Request $request)
{
    $request->validate([
        'name' => 'required|string|exists:users,name'
    ]);

    $auth = $request->user();

    $user = User::where('name', $request->name)->first();

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    if ($auth->id === $user->id) {
        return response()->json(['message' => 'Cannot friend yourself'], 400);
    }

    $exists = friend_request::where(function ($q) use ($auth, $user) {
        $q->where('sender_id', $auth->id)
          ->where('receiver_id', $user->id);
    })->orWhere(function ($q) use ($auth, $user) {
        $q->where('sender_id', $user->id)
          ->where('receiver_id', $auth->id);
    })->exists();

    if ($exists) {
        return response()->json(['message' => 'Request already exists'], 409);
    }

    // Check for badge BEFORE creating the request (to check if this is first)
    $badge = BadgeService::checkSocialStarter($auth);

    friend_request::create([
        'sender_id' => $auth->id,
        'receiver_id' => $user->id,
        'status' => 'pending'
    ]);

    return response()->json([
        'message' => 'Friend request sent',
        'badge' => $badge
    ], 201);
}

    // Accept request
    public function accept(Request $request, friend_request $friendRequest)
    {
        if ($friendRequest->receiver_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $friendRequest->update(['status' => 'accepted']);

        return response()->json(['message' => 'Friend request accepted']);
    }

    // Cancel a sent request (allows the sender to revoke a pending request)
    public function cancel(Request $request, friend_request $friendRequest)
    {
        if ($friendRequest->sender_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        if ($friendRequest->status !== 'pending') {
            return response()->json(['message' => 'Cannot cancel'], 400);
        }

        $friendRequest->delete();
        return response()->json(['message' => 'Friend request cancelled']);
    }

    public function remove(Request $request, User $user)
    {
        $auth = $request->user();

        $friendRequest = friend_request::where('status', 'accepted')
            ->where(function ($query) use ($auth, $user) {
                $query->where('sender_id', $auth->id)
                      ->where('receiver_id', $user->id);
            })
            ->orWhere(function ($query) use ($auth, $user) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', $auth->id);
            })
            ->first();

        if (!$friendRequest) {
            return response()->json(['message' => 'Friendship not found'], 404);
        }

        $friendRequest->delete();

        return response()->json(['message' => 'Friend removed']);
    }

    // Incoming *and* outgoing requests
    public function incoming(Request $request)
    {
        $user = $request->user();

        // eager load the related user objects so the frontend can access
        // `sender.name` / `receiver.name` without crashing when the relation is
        // not automatically serialized otherwise.
        $incoming = $user->receivedFriendRequests()
            ->where('status', 'pending')
            ->with('sender')
            ->get();

        $sent = $user->sentFriendRequests()
            ->where('status', 'pending')
            ->with('receiver')
            ->get();

        return response()->json([
            'incoming' => $incoming,
            'sent' => $sent,
        ]);
    }
}
