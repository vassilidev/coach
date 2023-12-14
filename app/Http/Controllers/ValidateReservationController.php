<?php

namespace App\Http\Controllers;

use App\Enums\Reservation\Status;
use App\Mail\MailToTeacher;
use App\Mail\MailToUser;
use App\Models\Checkout;
use Illuminate\Support\Facades\Mail;

class ValidateReservationController extends Controller
{

    public function __invoke(Checkout $checkout)
    {
        abort_unless($checkout->reservation, 403);
        abort_if($checkout->reservation->isFinished(), 403);
        abort_unless($checkout->isPaid(), 403);

        $checkout->reservation->update(['status' => Status::FINISHED->value]);
        $checkout->reservation->event->delete();

        Mail::to(config('mail.from.address'))->send(new MailToTeacher($checkout->reservation));
        Mail::to(config('mail.from.address'))->send(new MailToUser($checkout->reservation));

        return redirect()->route('front.home');
    }
}
