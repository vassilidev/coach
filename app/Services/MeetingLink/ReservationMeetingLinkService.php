<?php

namespace App\Services\MeetingLink;

use App\Contracts\ReservationMeetingLinkInterface;
use App\Models\Reservation;
use App\Services\MeetingLink\Providers\Jitsi\JitsiBuilder;
use App\Services\MeetingLink\Providers\Jitsi\JitsiReservationBuilder;

class ReservationMeetingLinkService extends MeetingLinkCreator
{
    protected array $matchingProvider = [
        JitsiBuilder::class => JitsiReservationBuilder::class,
    ];

    public function __construct(protected Reservation $reservation)
    {
        parent::__construct();
    }

    public function getMeetingLink(): string
    {
        return $this
            ->resolveMatchingProvider()
            ->setReservation($this->reservation)
            ->getMeetingLink();
    }

    public function resolveMatchingProvider(): ReservationMeetingLinkInterface
    {
        $vanillaProvider = $this->resolveProvider();

        return new $this->matchingProvider[$vanillaProvider::class];
    }
}