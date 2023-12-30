<?php

namespace App\Models;

use App\Casts\Price;
use App\Traits\Relations\BelongsTo\BelongsToCheckout;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use BelongsToCheckout;

    protected $fillable = [
        'invoice_id',
        'preview_url',
        'file_url',
        'amount',
        'invoice_data',
    ];

    protected $casts = [
        'amount' => Price::class,
        'invoice_data' => 'array',
    ];
}
