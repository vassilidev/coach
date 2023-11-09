<?php

namespace App\Enums\Stripe\Checkout;

enum PaymentStatus: string
{
    case PAID = 'paid';
    case UNPAID = 'unpaid';
    case NO_PAYMENT_REQUIRED = 'no_payment_required';
}
