<?php

namespace App\Actions\Stripe\Invoice;

use Stripe\Exception\ApiErrorException;
use Stripe\Invoice;

final class RetrieveInvoiceFromId
{
    /**
     * @throws ApiErrorException
     */
    public function execute(string $invoiceId): Invoice
    {
        return stripe()->invoices->retrieve($invoiceId);
    }
}