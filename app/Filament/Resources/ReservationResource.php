<?php

namespace App\Filament\Resources;

use App\Enums\Reservation\Status;
use App\Filament\Resources\ReservationResource\Pages;
use App\Filament\Resources\ReservationResource\RelationManagers;
use App\Models\Reservation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label(__('common.user'))
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Select::make('speciality_id')
                    ->relationship('speciality', 'name')
                    ->label(__('common.speciality'))
                    ->required(),
                Forms\Components\Select::make('event_id')
                    ->relationship('event', 'title')
                    ->label(__('common.event'))
                    ->required(),
                Forms\Components\Textarea::make('comment')
                    ->label(__('common.userComment')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('common.user'))
                    ->searchable(isIndividual: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('event.teacher.user.name')
                    ->label(__('common.coach'))
                    ->searchable(isIndividual: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('speciality.name')
                    ->label(__('common.speciality'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('event.title')
                    ->label(__('common.event'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('comment')
                    ->label(__('common.userComment'))
                    ->limit(15)
                    ->searchable(),
                Tables\Columns\TextColumn::make('event.start')
                    ->label(__('common.book.startHour'))
                    ->dateTime(config('datetime.format'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('event.end')
                    ->label(__('common.book.endHour'))
                    ->dateTime(config('datetime.format'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('common.status'))
                    ->badge()
                    ->color(fn(Status $state): string => match ($state->value) {
                        __('new') => 'warning',
                        __('finished') => 'success',
                        __('canceled') => 'danger',
                    }),
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
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label(__('common.deletedAt'))
                    ->dateTime(config('datetime.format'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }


    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
