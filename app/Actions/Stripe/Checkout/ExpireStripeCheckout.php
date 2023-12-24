<?php

namespace App\Actions\Stripe\Checkout;

use App\Models\Checkout;
use Stripe\Exception\ApiErrorException;

final class ExpireStripeCheckout
{
    /**
     * @throws ApiErrorException
     */
    public function execute(string $checkoutId): bool
    {
        stripe()->checkout->sessions->expire($checkoutId);

        return true;
    }
}