<?php

use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\Front\HomeController;
use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'front.',
], static function () {
    Route::get('/', HomeController::class)->name('home');
});

Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');