<?php

namespace App\Filament\Pages\Auth;

class Login extends \Filament\Pages\Auth\Login
{
    public function mount(): void
    {
        //TODO: Delete this file
        parent::mount();

        $this->form->fill([
            'email' => 'admin@admin.com',
            'password' => 'password',
            'remember' => true,
        ]);
    }
}