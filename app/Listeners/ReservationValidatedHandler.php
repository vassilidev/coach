<?php

namespace App\Listeners;

use App\Events\ReservationValidated;
use App\Mail\ReservationValidatedMailToTeacher;
use App\Mail\ReservationValidatedMailToUser;
use App\Services\MeetingLink\ReservationMeetingLinkService;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ReservationValidatedHandler
{
    /**
     * Handle the event.
     * @throws Throwable
     */
    public function handle(ReservationValidated $event): void
    {
        $reservation = $event->reservation;

        $meetingLinkService = new ReservationMeetingLinkService($reservation);

        $reservation->update([
            'meeting_link' => $meetingLinkService->getMeetingLink(),
        ]);

        Mail::to($reservation->event->teacher->user)->send(new ReservationValidatedMailToTeacher($reservation));

        Mail::to($reservation->user)->send(new ReservationValidatedMailToUser($reservation));

        $reservation->event->delete();

        Notification::make()
            ->title(__('common.book.bookSucceeded'))
            ->success()
            ->send();
    }
}
