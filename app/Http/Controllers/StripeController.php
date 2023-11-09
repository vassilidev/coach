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
