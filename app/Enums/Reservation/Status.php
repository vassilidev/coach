<?php

namespace App\Enums\Reservation;

enum Status: string
{
    case NEW = 'new';
    case FINISHED = 'finished';
    case CANCELED = 'canceled';
}
