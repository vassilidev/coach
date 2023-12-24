<?php

namespace App\Filament\Resources\ReservationResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Builder;

class EventRelationManager extends RelationManager
{
    protected static string $relationship = 'event';

    protected static ?string $title = 'Évènement';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(__('common.book.title'))
                    ->required(),
                Forms\Components\Select::make('teacher_id')
                    ->label(__('common.coach'))
                    ->relationship('teacher', 'id',)
                    ->required(),
                Forms\Components\DateTimePicker::make('start')
                    ->label(__('common.book.startHour'))
                    ->required(),
                Forms\Components\DateTimePicker::make('end')
                    ->label(__('common.book.startHour'))
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]))
            ->columns([
                Tables\Columns\TextColumn::make('teacher.user.name')
                    ->label(__('common.coach'))
                    ->searchable(isIndividual: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('common.event'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('start')
                    ->label(__('common.book.startHour'))
                    ->dateTime(config('datetime.format'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end')
                    ->label(__('common.book.endHour'))
                    ->dateTime(config('datetime.format'))
                    ->searchable()
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
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label(__('common.deletedAt'))
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
