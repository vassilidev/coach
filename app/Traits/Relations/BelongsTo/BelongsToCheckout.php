<?php

namespace App\Traits\Relations\BelongsTo;

use App\Models\Checkout;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToCheckout
{
    public function initializeBelongsToCheckout(): void
    {
        if (!in_array('stripe_checkout_id', $this->fillable, true)) {
            $this->fillable[] = 'stripe_checkout_id';
        }
    }

    /**
     * @return BelongsTo<Checkout, Model>
     */
    public function checkout(): BelongsTo
    {
        return $this->belongsTo(Checkout::class, 'stripe_checkout_id', 'id');
    }
}