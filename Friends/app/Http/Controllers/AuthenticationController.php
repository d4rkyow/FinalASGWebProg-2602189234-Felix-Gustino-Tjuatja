<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'gender' => 'required',
            'instagram_username' => 'required',
            'hobbies' => 'required|array|min:3',
            'mobile_number' => 'required',
        ]);

        $hobbies = implode(',', (array) $request->input('fields_of_hobbies'));
        $profilePath = 'profile_img/' . rand(1, 4) . '.jpg';
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'gender' => $validatedData['gender'],
            'instagram_username' => $validatedData['instagram_username'],
            'hobbies' => $hobbies,
            'mobile_number' => $validatedData['mobile_number'],
            'register_price' => rand(100000,125000),
            'profile_path' => $profilePath,
        ]);

        return redirect('/login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);

            return redirect()->route('user.index');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function update_paid(Request $request)
    {

        $validatedData = $request->validate([
            'payment_amount' => 'required|numeric|min:0',
            'price' => 'required|numeric',
        ]);

        $paymentAmount = $validatedData['payment_amount'];
        $price = $validatedData['price'];
        $difference = $paymentAmount - $price;

        $user = Auth::user();

        if ($difference < 0) {
            return redirect()->back()->with('error', 'You are still underpaid $' . number_format(-$difference, 2));
        } elseif ($difference > 0) {
            return redirect()->route('handle.overpayment', [
                'amount' => $difference,
                'payment_amount' => $paymentAmount,
                'price' => $price
            ]);
        } else {
            $user->has_paid = true;
            $user->save();
            return redirect()->route('user.index')->with('success', 'Payment successful!');
        }
    }

    public function handleOverpayment(Request $request)
    {
        $amount = $request->input('amount');
        $paymentAmount = $request->input('payment_amount');
        $price = $request->input('price');

        return view('overpayment', [
            'amount' => $amount,
            'payment_amount' => $paymentAmount,
            'price' => $price
        ]);
    }

    public function processOverpayment(Request $request)
    {
        $action = $request->input('action');
        $amount = $request->input('amount');
        $user = Auth::user();

        if ($action === 'accept') {
            $user->coins += $amount;
            $user->has_paid = true;
            $user->save();

            return redirect()->route('user.index')->with('success', 'The excess amount of $' . number_format($amount, 2) . ' has been converted to ' . $amount . ' coins and added to your wallet.');
        } else {
            return redirect()->route('pay')->with('error', 'Please enter the correct payment amount.');
        }
    }
}
