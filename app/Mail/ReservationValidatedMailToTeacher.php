<?php

namespace App\Mail;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationValidatedMailToTeacher extends Mailable
{
    use Queueable, SerializesModels;

    private Reservation $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        $date = Carbon::parse($this->reservation->event->start)->format(config('datetime.formatFrom')) .
            Carbon::parse($this->reservation->event->end)->format(config('datetime.formatTo'));

        return $this->markdown('mail.teacher')
            ->with([
                'teacherName' => $this->reservation->event->teacher->user->name,
                'userName'    => $this->reservation->user->name,
                'userEmail'   => $this->reservation->user->email,
                'date'        => $date,
                'price'       => $this->reservation->checkout->amount,
                'speciality'  => $this->reservation->speciality->name,
                'meetingLink' => $this->reservation->meeting_link,
            ]);
    }
}
