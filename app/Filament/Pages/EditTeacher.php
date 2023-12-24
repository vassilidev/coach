<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class EditTeacher extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.edit-teacher';

    public ?array $data = [];

    public function mount(): void
    {
        abort_unless(auth()->user()->isTeacher(), 403);

        $this->form->fill(Auth::user()->teacherProfile->attributesToArray());
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()->isTeacher();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                MarkdownEditor::make('description')
                    ->label(__('common.description'))
                    ->required()
                    ->columnSpanFull(),
            ])
            ->statePath('data');
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

        Auth::user()->teacherProfile()->update($data);

        Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
            ->send();
    }
}
