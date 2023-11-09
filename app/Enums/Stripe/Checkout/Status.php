<?php

namespace App\Enums\Stripe\Checkout;

enum Status: string
{
    case OPEN = 'open';
    case COMPLETE = 'complete';
    case EXPIRED = 'expired';
}
