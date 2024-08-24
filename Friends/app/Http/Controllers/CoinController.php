<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CoinController extends Controller
{

    public function topup(Request $request)
    {
        $user = Auth::user();
        $user->coins += 100;
        $user->save();

        return redirect()->back()->with('success', '100 coins added to your account!');
    }

}
