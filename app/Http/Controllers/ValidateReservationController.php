<?php

namespace App\Http\Controllers;

use App\Events\ReservationValidated;
use App\Filament\Resources\ReservationResource\Pages\ListReservations;
use App\Models\Checkout;

class ValidateReservationController extends Controller
{
    public function __invoke(Checkout $checkout)
    {
        abort_unless($checkout->reservation, 403);
        abort_if($checkout->reservation->isFinished(), 403);
        abort_unless($checkout->isPaid(), 403);

        event(new ReservationValidated($checkout->reservation));

        return redirect()->to(ListReservations::getUrl());
    }
}
