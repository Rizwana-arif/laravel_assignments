<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
// Add this ↓
Route::post('register', [RegisterController::class, 'register'])
    ->middleware('restrictothers');

// This serves as the create token page
Route::get('dashboard', function () {
    if(Auth::check() && Auth::user->role === 1) {
        return auth()
            ->user()
            ->createToken('auth_token', ['admin'])
            ->plainTextToken;
    }
    return redirect("/");

})->middleware('auth');

Route::get('clear/token', function () {
    if(Auth::check() && Auth::user()->role === 1) {
        Auth::user()->tokens()->delete();
    }

    return 'Token Cleared';
})->middleware('auth');
