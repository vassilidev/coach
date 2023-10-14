<?php

use App\Http\Controllers\Front\HomeController;
use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'front.',
], static function () {
    Route::get('/', HomeController::class)->name('home');
});