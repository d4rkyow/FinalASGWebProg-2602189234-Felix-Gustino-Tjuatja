<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\FriendRequest;
use App\Models\User;
use App\Notifications\FriendRequestAccepted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentUserID = Auth::user()->id;
        $dataFriend = Friend::where('user_id', '=', $currentUserID)->join('users', 'users.id', '=', 'friends.friend_id')->get(['users.*']);

        return view('friend', compact('dataFriend'));
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
        $currentUserID = Auth::user()->id;
        $friendID = $request->input('friend_id');
        $request_id = $request->input('request_id');
        
        $friend = Friend::create([
            'user_id' => $currentUserID,
            'friend_id' => $friendID
        ]);

        $friend2 = Friend::create([
            'user_id' => $friendID,
            'friend_id' => $currentUserID
        ]);

        $updateRequest = FriendRequest::find($request_id);
        $updateRequest->status = 'accepted';
        $updateRequest->save();

        $receiver = User::find($friendID);
        $receiver->notify(new FriendRequestAccepted($currentUserID));

        return redirect()->route('friend-request.index')->with('success', 'Friend request accepted and notification sent!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $friendID)
    {
        $currentUserID = Auth::user()->id;

        Friend::where(function($query) use ($currentUserID, $friendID) {
            $query->where('user_id', $currentUserID)
                ->where('friend_id', $friendID);
        })->orWhere(function($query) use ($currentUserID, $friendID) {
            $query->where('user_id', $friendID)
                ->where('friend_id', $currentUserID);
        })->delete();

        return redirect()->route('friend.index')->with('success', 'Friend removed successfully!');
    }
}
