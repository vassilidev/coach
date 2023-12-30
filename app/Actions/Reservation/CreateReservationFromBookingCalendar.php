<?php

namespace App\Actions\Reservation;

use App\Actions\Checkout\MakeCheckoutFromEvent;
use App\Actions\Stripe\Checkout\CreateStripeCheckoutFromCheckoutModel;
use App\Enums\Reservation\Status;
use App\Models\Checkout;
use App\Models\Event;
use App\Models\Reservation;
use App\Models\Speciality;
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
                'stripe_checkout_id' => $this->createCheckout($event, $data['speciality_id'])->id,
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
    private function createCheckout(Event $event, int $specialityId): Checkout
    {
        $user = Auth::user();

        $data = [
            'title'           => $event->title,
            'start'           => $event->start,
            'end'             => $event->end,
            'speciality_name' => Speciality::firstWhere('id', $specialityId)->name,
            'coach_name'      => $event->teacher->user->name,
            'customer_email'  => $user->email,
        ];

        return app(CreateStripeCheckoutFromCheckoutModel::class)
            ->execute(
                checkout: app(MakeCheckoutFromEvent::class)
                    ->execute(
                        event: $event,
                        user: $user,
                    ),
                data: $data
            );
    }
}
