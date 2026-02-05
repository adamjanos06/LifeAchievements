<?php

namespace App\Http\Controllers;

use App\Models\friend_request;
use App\Models\User;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    // List friends
    public function index(Request $request)
    {
        return response()->json([
            'data' => $request->user()->friends()->get()
        ]);
    }

    // Send friend request
    public function send(Request $request, User $user)
    {
        $auth = $request->user();

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

        friend_request::create([
            'sender_id' => $auth->id,
            'receiver_id' => $user->id,
        ]);

        return response()->json(['message' => 'Friend request sent'], 201);
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

    // Incoming requests
    public function incoming(Request $request)
    {
        return response()->json([
            'data' => $request->user()
                ->receivedFriendRequests()
                ->where('status', 'pending')
                ->get()
        ]);
    }
}
