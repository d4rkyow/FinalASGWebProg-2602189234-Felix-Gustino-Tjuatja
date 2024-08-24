<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show($id)
    {
        $user = Auth::user();

        if ($user->id != $id) {
            return redirect()->route('home')->with('error', 'Unauthorized access');
        }

        return view('profile', compact('user'));
    }
}

