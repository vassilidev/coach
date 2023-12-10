<?php

namespace App\Filament\Widgets;

use App\Actions\Checkout\DeleteAndExpireCheckout;
use App\Actions\Reservation\CreateReservationFromBookingCalendar;
use App\Models\Event;
use App\Models\Teacher;
use Exception;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class ClientBookTeacherCalendar extends FullCalendarWidget
{
    public ?Teacher $teacher = null;
    public string|int|null|Model $record = null;

    public function fetchEvents(array $info): array
    {
        if (!$this->teacher) {
            return [];
        }

        return $this->teacher->events()
            ->where('start', '>=', $info['start'])
            ->where('end', '<=', $info['end'])
            ->get()
            ->toArray();
    }

    public function onEventClick($event): void
    {
        $this->record = Event::find($event['id']);

        $this->mountAction('book');
    }

    protected function book(): CreateAction
    {
        return CreateAction::make()
            ->form([
                Section::make('Récapitulatif')
                    ->columns()
                    ->icon('heroicon-m-newspaper')
                    ->schema([
                        TextInput::make('title')
                            ->label(__('common.book.title'))
                            ->default($this->record->title)
                            ->disabled()
                            ->readOnly(),
                        TextInput::make('price')
                            ->label(__('common.book.price'))
                            ->default('50 €')
                            ->disabled()
                            ->readOnly(),
                        DateTimePicker::make('Heure de début')
                            ->label(__('common.book.startHour'))
                            ->disabled()
                            ->default($this->record->start),
                        DateTimePicker::make('Heure de fin')
                            ->label(__('common.book.endHour'))
                            ->disabled()
                            ->default($this->record->end),
                        Textarea::make('description')
                            ->label(__('common.book.coachDetails'))
                            ->default($this->teacher->description)
                            ->disabled()
                            ->readOnly()
                            ->autosize()
                            ->columnSpanFull(),
                        Textarea::make('coach-specialities')
                            ->label(__('common.book.coachSpecialities'))
                            ->default(implode(' | ', $this->teacher->specialities()->pluck('name')->toArray()))
                            ->disabled()
                            ->autosize()
                            ->readOnly()
                            ->columnSpanFull(),
                    ]),
                Select::make('speciality_id')
                    ->label(__('common.speciality'))
                    ->placeholder(__('common.book.chooseSpeciality'))
                    ->options($this->teacher->specialities()->pluck('name', 'id'))
                    ->columnSpanFull()
                    ->required()
                    ->searchable(),
                Textarea::make('comment')
                    ->placeholder(__('common.book.messageForCoach'))
                    ->autosize()
                    ->columnSpanFull(),
            ])
            ->modalSubmitActionLabel(__('common.book.make'))
            ->modalHeading(__('common.book.details'))
            ->successNotificationTitle(__('common.book.bookSucceeded'))
            ->failureNotificationTitle(__('common.book.bookFailed'))
            ->createAnother(false)
            ->using(function ($data) {
                DB::beginTransaction();

                $reservation = app(CreateReservationFromBookingCalendar::class)->execute(Auth::user(), $this->record, $data);

                try {
                    throw_if(is_null($reservation));

                    $this->record = $reservation;

                    DB::commit();
                } catch (Exception $exception) {
                    Log::error($exception);

                    app(DeleteAndExpireCheckout::class)->execute($reservation->checkout);

                    DB::rollBack();
                }
            })
            ->successRedirectUrl(fn() => $this->record->checkout->payment_url);
        //TODO: Check how can we change this to be more fluid and user friendly
    }
}
