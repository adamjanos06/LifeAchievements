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

    friend_request::create([
        'sender_id' => $auth->id,
        'receiver_id' => $user->id,
        'status' => 'pending'
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
