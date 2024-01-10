<?php

namespace App\Traits\ReservationMeeting;

use App\Contracts\ReservationMeetingLinkInterface;
use App\Models\Reservation;

trait InteractWithReservation
{
    public function getReservation(): Reservation
    {
        return $this->reservation;
    }

    public function setReservation(Reservation $reservation): ReservationMeetingLinkInterface
    {
        $this->reservation = $reservation;

        return $this;
    }
}