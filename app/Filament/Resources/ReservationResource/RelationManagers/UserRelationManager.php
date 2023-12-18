<?php

namespace App\Filament\Resources\ReservationResource\RelationManagers;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Builder;

class UserRelationManager extends RelationManager
{
    protected static string $relationship = 'user';

    protected static ?string $title = 'Utilisateur';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('common.name'))
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(),
                Forms\Components\DateTimePicker::make('email_verified_at')
                    ->hiddenOn('create'),
                Forms\Components\TextInput::make('login_provider')
                    ->readOnly()
                    ->disabled()
                    ->hiddenOn('create'),
                Forms\Components\TextInput::make('socialite_id')
                    ->readOnly()
                    ->hiddenOn('create')
                    ->disabled(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]))
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('common.name'))
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(isIndividual: true)
                    ->toggleable(),
                Tables\Columns\IconColumn::make('has_teacher_profile')
                    ->label('Coach?')
                    ->getStateUsing(fn(User $user) => $user->teacherProfile)
                    ->boolean()
                    ->default(false),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label(__('common.verifiedAt'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime(config('datetime.format'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('common.createdAt'))
                    ->dateTime(config('datetime.format'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('common.updatedAt'))
                    ->dateTime(config('datetime.format'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('login_provider')
                    ->searchable(isIndividual: true)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('socialite_id')
                    ->searchable(isIndividual: true)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime(config('datetime.format'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
