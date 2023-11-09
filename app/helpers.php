<?php

use Stripe\StripeClient;

if (!function_exists('stripe')) {
    function stripe(): StripeClient
    {
        return new StripeClient(config('stripe.secret'));
    }
}
