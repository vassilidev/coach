<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::before(static function ($user) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        Gate::define('teacher', static function (User $user) {
            return $user->isTeacher();
        });
    }
}
