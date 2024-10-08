<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request)
    {
        $senderID = Auth::user()->id;
        $receiverID = $request->input('friend_id');

        // Validate the input
        $request->validate([
            'new_message' => 'nullable|string|max:255',
            'avatar_id' => 'nullable|exists:avatars,id',
        ]);

        // Create and save the new message
        $message = Message::create([
            'sender_id' => $senderID,
            'receiver_id' => $receiverID,
            'message' => $request->input('new_message'),
        ]);

        // Handle avatar sending
        $avatarId = $request->input('avatar_id');
        if ($avatarId) {
            $user = Auth::user();
            $avatar = Avatar::findOrFail($avatarId);

            // Create AvatarTransfer entry
            AvatarTransfer::create([
                'sender_id' => $senderID,
                'receiver_id' => $receiverID,
                'avatar_id' => $avatar->id,
            ]);
        }

        return redirect()->route('message.show', $receiverID);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $currentUserID = Auth::user()->id;
        $friend = User::findOrFail($id);

        $messages = Message::where(function ($query) use ($currentUserID, $id) {
            $query->where('sender_id', $currentUserID)
                ->where('receiver_id', $id);
        })->orWhere(function ($query) use ($currentUserID, $id) {
            $query->where('sender_id', $id)
                ->where('receiver_id', $currentUserID);
        })->orderBy('created_at', 'asc')->get();

        return view('message', compact('friend', 'messages'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
