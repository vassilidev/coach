<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\ValidateStripeCheckoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;

Route::group([
    'as' => 'front.',
], static function () {
    Route::get('/', HomeController::class)->name('home');
});

Route::group(['middleware' => 'guest', 'as' => 'socialite.'], static function () {
    Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect'])->name('redirect');
    Route::get('/auth/callback/{provider}', [SocialiteController::class, 'callback'])->name('callback');
});

Route::get('stripe/create-checkout-session',  [StripeController::class, 'createCheckoutSession'])->name('stripe.create-checkout-session');
Route::get('stripe/success/{checkout}', ValidateStripeCheckoutController::class)->name('stripe.success');
Route::get('stripe/cancel',  [StripeController::class, 'cancel'])->name('stripe.cancel');
