<?php

namespace App\Enums\Auth;

enum SocialiteProvider: string
{
    case GOOGLE = 'google';

    public function getLabel(): string
    {
        return match ($this) {
            self::GOOGLE => 'Google',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::GOOGLE => 'bi-google',
        };
    }
}