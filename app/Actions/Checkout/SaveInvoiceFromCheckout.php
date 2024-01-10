<?php

namespace App\Actions\Checkout;

use App\Actions\Stripe\Invoice\RetrieveInvoiceFromId;
use App\Models\Checkout;
use App\Models\Invoice;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\ApiErrorException;

final class SaveInvoiceFromCheckout
{
    /**
     * @throws ApiErrorException
     */
    public function execute(Checkout $checkout): ?Invoice
    {
        if (!$invoiceId = $checkout->checkout_data['invoice']) {
            return null;
        }

        $stripeInvoice = app(RetrieveInvoiceFromId::class)->execute(invoiceId: $invoiceId);

        if (!$stripeInvoice) {
            Log::error('No Stripe Invoice found for ID : ' . $invoiceId);

            return null;
        }

        return Invoice::create([
            'invoice_id'         => $stripeInvoice->id,
            'stripe_checkout_id' => $checkout->id,
            'preview_url'        => $stripeInvoice->hosted_invoice_url,
            'file_url'            => $stripeInvoice->invoice_pdf,
            'amount'             => $stripeInvoice->total,
            'invoice_data'       => $stripeInvoice,
        ]);
    }
}