<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Front\HomeController;
use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'front.',
], static function () {
    Route::get('/', HomeController::class)->name('home');
});

Route::group(['middleware' => 'guest', 'as' => 'socialite.'], static function () {
    Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect'])->name('redirect');
    Route::get('/auth/callback/{provider}', [SocialiteController::class, 'callback'])->name('callback');
});