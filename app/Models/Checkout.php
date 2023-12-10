<?php

namespace App\Models;

use App\Casts\Price;
use App\Enums\Stripe\Checkout\PaymentStatus;
use App\Enums\Stripe\Checkout\Status;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasUlids;

    protected $table = 'stripe_checkouts';

    protected $fillable = [
        'user_id',
        'checkout_id',
        'payment_status',
        'status',
        'checkout_data',
        'amount',
        'redirect_url',
    ];

    protected $casts = [
        'payment_status' => PaymentStatus::class,
        'status' => Status::class,
        'amount' => Price::class,
        'checkout_data' => 'array',
    ];

    public function isPaid(): bool
    {
        return $this->payment_status === PaymentStatus::PAID;
    }

    public function isComplete(): bool
    {
        return $this->payment_status === Status::COMPLETE;
    }

    public function paymentUrl(): Attribute
    {
        // TODO : Implement refresh URL fo the Session if expire / check expire
        
        return Attribute::get(fn() => $this->checkout_data['url']);
    }
}
