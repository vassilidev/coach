<?php

namespace App\Http\Controllers;

use App\Enums\Stripe\Checkout\PaymentStatus;
use App\Models\Checkout;
use JsonException;
use Stripe\Exception\ApiErrorException;

class ValidateStripeCheckoutController extends Controller
{
    /**
     * Handle the incoming request.
     * @throws JsonException|ApiErrorException
     */
    public function __invoke(Checkout $checkout)
    {
        abort_if($checkout->isPaid() || $checkout->isComplete(), 403);

        $stripeCheckout = stripe()->checkout->sessions->retrieve($checkout->checkout_id);

        abort_unless($stripeCheckout->payment_status === PaymentStatus::PAID->value, 403);

        $checkout->update([
            'payment_status' => $stripeCheckout->payment_status,
            'status' => $stripeCheckout->status,
            'checkout_data' => json_encode($stripeCheckout, JSON_THROW_ON_ERROR),
        ]);

        if ($checkout->redirect_url) {
            return redirect($checkout->redirect_url);
        }

        return redirect('home');
    }
}
