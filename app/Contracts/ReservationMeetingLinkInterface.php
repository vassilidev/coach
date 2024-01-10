<?php

namespace App\Contracts;

use App\Models\Reservation;

interface ReservationMeetingLinkInterface
{
    public function getReservation(): Reservation;

    public function setReservation(Reservation $reservation): self;
}