<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class ClientBookTeacherCalendar extends FullCalendarWidget
{
    public $teacher;
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
                Select::make('speciality')
                    ->label(__('common.speciality'))
                    ->placeholder(__('common.book.chooseSpeciality'))
                    ->options($this->teacher->specialities()->pluck('name', 'id'))
                    ->columnSpanFull()
                    ->required()
                    ->searchable(),
                Textarea::make('message')
                    ->placeholder(__('common.book.messageForCoach'))
                    ->autosize()
                    ->columnSpanFull(),
            ])
            ->successNotificationTitle(__('common.book.bookSucceeded'))
            ->failureNotificationTitle(__('common.book.bookFailed'))
            ->createAnother(false);
    }
}
