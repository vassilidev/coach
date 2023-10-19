<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeController extends Controller
{

    /**
     * @param Request $request
     * @return View
     * @throws ApiErrorException
     */
    public function createCheckoutSession(Request $request): View
    {
        Stripe::setApiKey(config('stripe.secret'));

        $checkout_session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => 1000,
                    'product_data' => [
                        'name' => 'Nom du produit',
                        'description' => 'Description du produit',
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripe.success'),
            'cancel_url' => route('stripe.cancel'),
        ]);

        return view('stripe.index', ['checkout_session_id' => $checkout_session->id]);
    }

    /**
     * @return RedirectResponse
     */
    public function success(): RedirectResponse
    {
        return redirect()->route('front.home')->with('success', 'Paiement réussi.');
    }

    /**
     * @return RedirectResponse
     */
    public function cancel(): RedirectResponse
    {
        return redirect()->route('front.home')->with('danger', 'Paiement annulé.');
    }
}
