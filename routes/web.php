<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/ip-management', function () {
        return Inertia::render('IpManagement');
    })->name('ip-management');



});

// Route to generate an API token for the authenticated user
Route::middleware(['auth'])->get('/generate-token', function (Request $request) {
    $user = $request->user();
    $token = $user->currentAccessToken() ? $user->currentAccessToken()->plainTextToken : $user->createToken('default')->plainTextToken;

    return response()->json(['token' => $token]);
});

