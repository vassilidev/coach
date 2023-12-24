<?php

namespace App\Actions\Checkout;

use App\Enums\Stripe\Checkout\PaymentStatus;
use App\Enums\Stripe\Checkout\Status;
use App\Models\{Checkout, Event, User};
use Illuminate\Support\Str;

final class MakeCheckoutFromEvent
{
    public function execute(
        Event $event,
        User  $user,
        ?int  $price = null,
    ): Checkout
    {
        $price ??= (int)config('reservations.defaultPrice');

        $id = Str::ulid();

        return (new Checkout)->forceFill([
            'id'             => $id,
            'user_id'        => $user->id,
            'payment_status' => PaymentStatus::UNPAID,
            'status'         => Status::OPEN,
            'amount'         => $price,
            'redirect_url'   => route('reservation.success', $id),
        ]);
    }
}
