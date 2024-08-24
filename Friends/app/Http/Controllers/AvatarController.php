<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvatarController extends Controller
{
    public function index()
    {
        // Daftar avatar dengan harga yang bervariasi
        $avatars = [
            ['id' => 1, 'path' => 'avatars/avatar1.jpg', 'price' => 100],
            ['id' => 2, 'path' => 'avatars/avatar2.jpg', 'price' => 500],
            ['id' => 3, 'path' => 'avatars/avatar3.jpg', 'price' => 1000],
            ['id' => 4, 'path' => 'avatars/avatar4.jpg', 'price' => 5000],
            ['id' => 5, 'path' => 'avatars/avatar5.jpg', 'price' => 10000],
            ['id' => 6, 'path' => 'avatars/avatar6.jpg', 'price' => 50000],
            ['id' => 7, 'path' => 'avatars/avatar7.jpg', 'price' => 100000],
        ];

        return view('avatar', compact('avatars'));  // Menyesuaikan view ke 'avatar.blade.php'
    }

    public function buy(Request $request)
    {
        $user = Auth::user();
        $avatarPrice = $request->input('price');
        $avatarPath = $request->input('path');

        if ($user->coins >= $avatarPrice) {
            $user->coins -= $avatarPrice;
            $user->profile_path = $avatarPath;
            $user->save();

            return redirect()->route('avatar.index')->with('success', 'Avatar purchased successfully!');
        } else {
            return redirect()->route('avatar.index')->with('error', 'Not enough coins to purchase this avatar.');
        }
    }
}
