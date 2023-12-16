<?php

namespace App\Mail;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailToTeacher extends Mailable
{
    use Queueable, SerializesModels;

    private Model $reservation;

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
                'teacher_name' => $this->reservation->event->teacher->user->name,
                'user_name' => $this->reservation->user->name,
                'user_email' => $this->reservation->user->email,
                'event_name' => $this->reservation->event->name,
                'date' => $date,
                'price' => $this->reservation->checkout->amount,
                'speciality' => $this->reservation->speciality->name,
                'link_google_meet' => 'https://google.com',
            ]);
    }
}