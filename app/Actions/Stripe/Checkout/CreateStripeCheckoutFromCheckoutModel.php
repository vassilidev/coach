<?php

namespace App\Actions\Stripe\Checkout;

use App\Models\Checkout;
use Carbon\Carbon;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;

final class CreateStripeCheckoutFromCheckoutModel
{
    /**
     * @throws ApiErrorException
     */
    public function execute(Checkout $checkout, array $data = []): Checkout
    {
        /** @var Session $checkoutData */
        //TODO: Add customer address, in waiting to have true data, make it fake
        $checkoutData = stripe()->checkout->sessions->create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => 'eur',
                        'product_data' => [
                            'name' => 'Paiement # ' . $checkout->id,
                            'description' => 'Réservation de ' . $data['title'] .
                                ' qui se déroulera le ' . Carbon::parse($data['start'])->format(config('datetime.formatFrom')) .
                                Carbon::parse($data['end'])->format(config('datetime.formatTo')) .
                                    ' afin de développer la spécialité ' . $data['speciality_name'] .
                            ' avec le coach ' . $data['coach_name'],
                        ],
                        'unit_amount'  => $checkout->amount,
                    ],
                    'quantity'   => 1,
                ]
            ],
            'mode'        => 'payment',
            'locale'      => 'fr',
            'success_url' => route('stripe.success', $checkout),
            'cancel_url'  => route('stripe.cancel'),
        ]);

        $checkout->forceFill([
            'checkout_data' => $checkoutData,
            'checkout_id'   => $checkoutData->id,
        ]);

        $checkout->save();

        return $checkout;
    }
}
