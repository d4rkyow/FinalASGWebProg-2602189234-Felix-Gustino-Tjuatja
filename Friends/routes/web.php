<?php

use App\Http\Controllers\AvatarController;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;



Route::get('/register', function () {
    return view('auth.register');
});

Route::post('/register', [AuthenticationController::class, 'register'])->name('saveRegister');

Route::get('/login', function () {
    return view('auth.login');
});

Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
Route::post('/logout', [AuthenticationController::class, 'logout']);


Route::get('/pay', function () {
    $user = Auth::user();
    $price = $user->register_price;
    return view('pay', compact('price'));
})->name('pay');

Route::get('/overpayment', [AuthenticationController::class, 'handleOverpayment'])->name('handle.overpayment');
Route::post('/overpayment', [AuthenticationController::class, 'processOverpayment'])->name('process.overpayment');

Route::post('/updatePaid', [AuthenticationController::class, 'update_paid'])->name('updatePaid');

Route::middleware(['auth', 'paid'])->group(function () {
    Route::get('/', function () {
        return view('home');
    });

    Route::resource('user', UserController::class);
    Route::resource('friend-request', FriendRequestController::class);
    Route::resource('friend', FriendController::class);
    Route::resource('message', MessageController::class);
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/friend/{friend}', [FriendController::class, 'destroy'])->name('friend.destroy');

});
Route::get('/profile', [UserController::class, 'showProfile'])->name('profile')->middleware('auth');

Route::get('/avatar', [AvatarController::class, 'index'])->name('avatar.index');
Route::post('/avatar/buy', [AvatarController::class, 'buy'])->name('avatar.buy');
Route::post('/topup-coins', [CoinController::class, 'topup'])->name('topup.coins');

Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
Route::post('/settings/disappear', [SettingsController::class, 'disappear'])->name('settings.disappear');

Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
Route::post('/settings/reappear', [SettingsController::class, 'reappear'])->name('settings.reappear');

Route::get('set-locale/{locale}', function ($locale) {
    session(['locale' => $locale]);
    return redirect()->back();
})->name('setLocale');
