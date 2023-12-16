<?php

namespace App\Filament\Pages;

use Exception;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class EditProfile extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.edit-profile';

    protected static bool $shouldRegisterNavigation = false;

    public ?array $profileData = [];
    public ?array $passwordData = [];

    /**
     * @throws Exception
     */
    public function mount(): void
    {
        $this->fillForms();
    }

    protected function getForms(): array
    {
        return [
            'editProfileForm',
            'editPasswordForm',
        ];
    }

    /**
     * @throws Exception
     */
    protected function getUser(): Authenticatable|Model
    {
        $user = Filament::auth()->user();

        if (!$user instanceof Model) {
            throw new Exception('The authenticated user object must be an Eloquent model to allow the profile page to update it.');
        }

        return $user;
    }

    /**
     * @throws Exception
     */
    protected function fillForms(): void
    {
        $data = $this->getUser()->attributesToArray();

        $this->editProfileForm->fill($data);
    }

    /**
     * @throws Exception
     */
    public function editProfileForm(Form $form): Form
    {
        return
            $form->schema([
                    Section::make('Profile Information')
                        ->aside()
                        ->description('Update your account\'s profile information and email address.')
                        ->schema([
                            TextInput::make('name')
                                ->required(),
                            TextInput::make('email')
                                ->email()
                                ->required()
                                ->unique(ignoreRecord: true),
                        ]),
                ]
            )
                ->model($this->getUser())
                ->statePath('profileData');
    }

    /**
     * @throws Exception
     */
    public function editPasswordForm(Form $form): Form
    {
        return $form->schema([
            Section::make('Update Password')
                ->aside()
                ->description('Ensure your account is using long, random password to stay secure.')
                ->schema([
                    TextInput::make('Current password')
                        ->password()
                        ->required()
                        ->currentPassword(),
                    TextInput::make('password')
                        ->password()
                        ->required()
                        ->rule(Password::default())
                        ->autocomplete('new-password')
                        ->dehydrateStateUsing(fn($state): string => Hash::make($state))
                        ->live(debounce: 500)
                        ->same('passwordConfirmation'),
                    TextInput::make('passwordConfirmation')
                        ->password()
                        ->required()
                        ->dehydrated(false),
                ]),
        ])
            ->model($this->getUser())
            ->statePath('passwordData');
    }

    protected function getUpdateProfileFormActions(): array
    {
        return [
            Action::make('updateProfileAction')
                ->label(__('filament-panels::pages/auth/edit-profile.form.actions.save.label'))
                ->submit('editProfileForm'),
        ];
    }

    protected function getUpdatePasswordFormActions(): array
    {
        return [
            Action::make('updatePasswordAction')
                ->label(__('filament-panels::pages/auth/edit-profile.form.actions.save.label'))
                ->submit('editPasswordForm'),
        ];
    }

    /**
     * @throws Exception
     */
    public function updateProfile(): void
    {
        $data = $this->editProfileForm->getState();

        $this->handleRecordUpdate($this->getUser(), $data);

        $this->sendSuccessNotification();
    }

    /**
     * @throws Exception
     */
    public function updatePassword(): void
    {
        $data = $this->editPasswordForm->getState();

        if (array_key_exists('password', $data) && request()->hasSession()) {
            request()->session()->put(['password_hash_' . Filament::getAuthGuard() => $data['password']]);
        }

        $this->editPasswordForm->fill();

        $this->sendSuccessNotification();
    }

    private function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        return $record;
    }

    public function sendSuccessNotification(): void
    {
        Notification::make()
            ->success()
            ->title(__('filament-panels::pages/auth/edit-profile.notifications.saved.title'))
            ->send();
    }
}
