<?php

namespace App\Providers;

use App\Models\User;
use Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::if('teacher', static function ($user = null) {
            /** @var User $user */
            $user = (is_a($user, Authenticatable::class)) ? $user : Auth::user();

            return $user->can('teacher');
        });
    }
}
