<?php

namespace App\Enums\Reservation;

use Filament\Support\Colors\Color;

enum Status: string
{
    case NEW = 'new';
    case FINISHED = 'finished';
    case CANCELED = 'canceled';

    public function color(): array
    {
        return match ($this) {
            self::NEW => Color::Green,
            self::FINISHED => Color::Blue,
            self::CANCELED => Color::Red,
        };
    }

    public function label(): string
    {
        return __('common.' . $this->value);
    }
}
