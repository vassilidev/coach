<?php

namespace App\Filament\Resources\TeacherResource\Widgets;

use App\Models\Event;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Saade\FilamentFullCalendar\Actions\{CreateAction, DeleteAction, EditAction};
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class TeacherCalendarWidget extends FullCalendarWidget
{
    public string|null|Model $model = Event::class;

    public function getFormSchema(): array
    {
        return [
            TextInput::make('title')
                ->required(),

            Grid::make()
                ->schema([
                    DateTimePicker::make('start'),
                    DateTimePicker::make('end'),
                ]),
        ];
    }

    protected function headerActions(): array
    {
        return [
            CreateAction::make()
                ->mountUsing(
                    function (Form $form, array $arguments) {
                        $form->fill([
                            'start' => $arguments['start'] ?? null,
                            'end'   => $arguments['end'] ?? null
                        ]);
                    }
                )
                ->using(function (array $data, string $model): Model {
                    $data = array_merge($data, ['teacher_id' => Auth::user()->teacherProfile->id]); // TODO find a cleaner way to add the teacher_id
                    return Auth::user()->teacherProfile->events()->save($model::create($data));
                })
        ];
    }

    public function fetchEvents(array $info): array
    {
        return Auth::user()->teacherProfile->events()
            ->where('start', '>=', $info['start'])
            ->where('end', '<=', $info['end'])
            ->get()
            ->toArray();
    }

    protected function modalActions(): array
    {
        return [
            EditAction::make()
                ->mountUsing(
                    function (Event $record, Form $form, array $arguments) {
                        $form->fill([
                            'title' => $record->title,
                            'start' => $arguments['event']['start'] ?? $record->start,
                            'end'   => $arguments['event']['end'] ?? $record->end
                        ]);
                    }
                )
                ->modalHeading(__('pages/events.editEventTeacher')),
            DeleteAction::make()
                ->action(function (Event $event) {
                    $event->delete();

                    $this->record = null;
                })
                ->requiresConfirmation(),
        ];
    }
}
