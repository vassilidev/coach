<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
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
                    ->schema([
                        // NOTE(BENJ): Recapitulatif du caoch
                        // Recapitulatif de ses sports etc..
                        // Recap prix (50e en dur)

                        TextInput::make('title')
                            ->default($this->record->title)
                            ->readOnly(),
                    ]),

                Select::make('activity') // TODO Rename
                    ->options($this->teacher->specialities()->pluck('name', 'id'))
                    ->searchable(),

                // TODO add message to the coach
                // TODO: add any fields u judge required
                // https://filamentphp.com/docs/3.x/actions/prebuilt-actions/create
                // Voir les notifs
            ])
            ->createAnother(false);
    }
}
