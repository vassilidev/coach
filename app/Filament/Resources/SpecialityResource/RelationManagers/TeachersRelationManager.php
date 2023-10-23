<?php

namespace App\Filament\Resources\SpecialityResource\RelationManagers;

use App\Models\Teacher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TeachersRelationManager extends RelationManager
{
    protected static string $relationship = 'teachers';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\MarkdownEditor::make('description')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitle(fn(Teacher $teacher) => $teacher->user->name)
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable()
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y \à H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d/m/Y \à H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime('d/m/Y \à H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(isIndividual: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('user')
                    ->relationship('user', 'name')
                    ->multiple(),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect(),
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
