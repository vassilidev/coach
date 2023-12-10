<?php

namespace App\Actions\Checkout;

use App\Actions\Stripe\Checkout\ExpireStripeCheckout;
use App\Models\Checkout;
use Stripe\Exception\ApiErrorException;

final class DeleteAndExpireCheckout
{
    /**
     * @throws ApiErrorException
     */
    public function execute(Checkout $checkout): bool
    {
        if ($this->expireCheckout($checkout)) {
            return $checkout->delete() ?? false;
        }

        return false;
    }

    /**
     * @throws ApiErrorException
     */
    private function expireCheckout(Checkout $checkout): bool
    {
        return app(ExpireStripeCheckout::class)->execute($checkout->checkout_id);
    }
}