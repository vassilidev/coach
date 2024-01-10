<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Auth\SocialiteProvider;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SocialiteController extends Controller
{
    /**
     * @param SocialiteProvider $provider Match the provider from the Enum class.
     *
     * @return RedirectResponse Redirect to the login page.
     */
    public function redirect(SocialiteProvider $provider): RedirectResponse
    {
        $scopes = optional(config('services.' . $provider->value . '.scopes')) ?? [];

        return Socialite::driver($provider->value)
            ->scopes($scopes)
            ->redirect();
    }

    /**
     * @param SocialiteProvider $provider Match the provider from the Enum class.
     *
     * @return RedirectResponse
     */
    public function callback(
        SocialiteProvider $provider
    ): RedirectResponse
    {
        $userData = Socialite::driver($provider->value)->user();

        $user = User::updateOrCreate(
            [
                'socialite_id'   => $userData->getId(),
                'login_provider' => $provider,
            ],
            [
                'password'                => Hash::make($userData->token),
                'name'                    => $userData->getName(),
                'email'                   => $userData->getEmail(),
                'socialite_token'         => $userData->token,
                'socialite_refresh_token' => $userData->refreshToken,
            ]
        );

        Auth::login($user);

        return to_route('filament.admin.pages.dashboard');
    }
}