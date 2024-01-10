<?php

namespace App\Filament\Resources\ReservationResource\Pages;

use App\Filament\Resources\ReservationResource;
use App\Models\Reservation;
use Filament\Actions\Action;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Auth;

class CustomEditReservation extends Page
{
    use InteractsWithRecord;

    public static bool $shouldRegisterNavigation = false;

    protected static string $resource = ReservationResource::class;

    protected static string $view = 'filament.resources.reservation-resource.pages.edit-reservation';

    public ?string $comment = null;

    protected function getRecord(): Reservation
    {
        return Reservation::findOrFail($this->record);
    }

    public function mount(): void
    {
        $this->form->fill($this->getRecord()->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                MarkdownEditor::make('comment')
                    ->label(__('common.book.messageForCoach'))
                    ->required()
                    ->columnSpanFull(),
            ]);

    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        Auth::user()->reservations()->firstWhere('id', $this->record)->update($data);

        Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
            ->send();
    }
}
