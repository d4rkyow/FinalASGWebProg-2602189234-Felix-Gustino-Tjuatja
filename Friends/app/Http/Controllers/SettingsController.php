<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('settings', compact('user'));
    }

    public function disappear(Request $request)
{
    $user = Auth::user();

    if ($user->coins < 50) {
        return redirect()->route('settings.index')->with('error', 'Not enough coins!');
    }


    $user->coins -= 50;

    $bearPhotos = [
        'bears/bear1.jpg',
        'bears/bear2.jpg',
        'bears/bear3.jpg',
    ];

    $randomBearPhoto = $bearPhotos[array_rand($bearPhotos)];

    $user->profile_path = $randomBearPhoto;

    $user->visible = false;

    $user->save();

    return redirect()->route('settings.index')->with('success', 'You have disappeared from the home list!');
}

public function reappear(Request $request)
{
    $user = Auth::user();

    if ($user->coins < 5) {
        return redirect()->route('settings.index')->with('error', 'Not enough coins!');
    }

    $user->coins -= 5;

    $user->visible = true;

    $user->save();

    return redirect()->route('settings.index')->with('success', 'Your photo is now visible and searchable again!');
}


}
