<?php

namespace App\Services\MeetingLink\Providers\Jitsi;

use App\Contracts\ReservationMeetingLinkInterface;
use App\Traits\ReservationMeeting\InteractWithReservation;
use Illuminate\Support\Str;

class JitsiReservationBuilder extends JitsiBuilder implements ReservationMeetingLinkInterface
{
    use InteractWithReservation;

    public function getMeetingLink(): string
    {
        $this->setRoomName($this->generateRoomSlug());

        return parent::getMeetingLink();
    }

    private function generateRoomSlug(): string
    {
        return config('app.name')
            . '/'
            . Str::slug(
                'reservation'
                . ' '
                . $this->getReservation()->id
                . $this->getReservation()->event->teacher->id
                . Str::uuid(),
            );
    }
}