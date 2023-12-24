<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'bi-people-fill';

    public static function form(Form $form): Form
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

    public static function table(Table $table): Table
    {
        return $table
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
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\Filter::make('Coach?')
                    ->translateLabel()
                    ->query(fn(Builder $query): Builder => $query->whereHas('teacherProfile')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                ExportBulkAction::make(),
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'edit'  => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getModelLabel(): string
    {
        return __('common.user');
    }

    public static function getPluralModelLabel(): string
    {
        return __('common.users');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
