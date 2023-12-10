<?php

namespace App\Actions\Reservation;

use App\Actions\Checkout\MakeCheckoutFromEvent;
use App\Actions\Stripe\Checkout\CreateStripeCheckoutFromCheckoutModel;
use App\Enums\Reservation\Status;
use App\Models\Checkout;
use App\Models\Event;
use App\Models\Reservation;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Stripe\Exception\ApiErrorException;

final class CreateReservationFromBookingCalendar
{
    public function execute(
        User  $user,
        Event $event,
        array $data,
    ): ?Reservation
    {
        try {
            return $user->reservations()->create([
                'stripe_checkout_id' => $this->createCheckout($event)->id,
                'event_id'           => $event->id,
                'status'             => Status::NEW,
                'speciality_id'      => $data['speciality_id'],
                'comment'            => $data['comment'],
            ]);
        } catch (Exception $exception) {
            return null;
        }
    }

    /**
     * @throws ApiErrorException
     */
    private function createCheckout(Event $event): Checkout
    {
        return app(CreateStripeCheckoutFromCheckoutModel::class)
            ->execute(
                checkout: app(MakeCheckoutFromEvent::class)
                    ->execute(
                        event: $event,
                        user: Auth::user(),
                    ),
            );
    }
}