<?php

namespace App\Providers;

use App\Events\ReservationValidated;
use App\Listeners\ReservationValidatedHandler;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class           => [
            SendEmailVerificationNotification::class,
        ],
        ReservationValidated::class => [
            ReservationValidatedHandler::class,
        ]
    ];
}
