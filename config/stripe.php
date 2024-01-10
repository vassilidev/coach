<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Stripe API Key
    |--------------------------------------------------------------------------
    |
    | Your Stripe public API key. This key will be used for all requests made
    | through the Stripe SDK.
    |
    */

    'key' => env('STRIPE_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Stripe Secret Key
    |--------------------------------------------------------------------------
    |
    | Your Stripe secret API key. This key should never be exposed to the client
    | side and should be kept secure.
    |
    */

    'secret' => env('STRIPE_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Stripe Webhook Secret
    |--------------------------------------------------------------------------
    |
    | Your Stripe Webhook secret. This secret is used to verify that the incoming
    | webhook requests are genuinely from Stripe.
    |
    */
];
