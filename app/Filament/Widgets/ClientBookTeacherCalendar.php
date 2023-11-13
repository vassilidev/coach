<?php

namespace App\Filament\Widgets;

use App\Contracts\HasEvents;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Actions\ViewAction;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class ClientBookTeacherCalendar extends FullCalendarWidget
{
    /**
     * @var HasEvents|string|int|Model|null
     */
    public string|int|null|Model $record = null;

    public function getFormSchema(): array
    {
        return [
            TextInput::make('title'),

            Grid::make()
                ->schema([
                    DateTimePicker::make('start'),
                    DateTimePicker::make('end'),
                ]),
        ];
    }

    public function fetchEvents(array $info): array
    {
        return $this->record->events()
            ->where('start', '>=', $info['start'])
            ->where('end', '<=', $info['end'])
            ->get()
            ->toArray();
    }

    protected function viewAction(): ViewAction
    {
        return ViewAction::make()->mountUsing(
            function ($record, Form $form) {
                $form->fill([]); // TODO: Make it work :(
            }
        );
    }
}
