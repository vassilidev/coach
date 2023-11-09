<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherResource\Pages;
use App\Filament\Resources\TeacherResource\RelationManagers;
use App\Models\Teacher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-s-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label(__('common.user'))
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\MarkdownEditor::make('description')
                    ->label(__('common.description'))
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitle(fn(Teacher $teacher): string => $teacher->user->name)
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable(isIndividual: true)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('common.name'))
                    ->numeric()
                    ->sortable()
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('specialities_count')
                    ->label(__('common.specialities'))
                    ->sortable()
                    ->toggleable()
                    ->counts('specialities')
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('common.createdAt'))
                    ->dateTime(config('datetime.format'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('common.updatedAt'))
                    ->dateTime(config('datetime.format'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label(__('common.deletedAt'))
                    ->dateTime(config('datetime.format'))
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
            ->actions([
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

    public static function getRelations(): array
    {
        return [
            RelationManagers\SpecialitiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTeachers::route('/'),
            'create' => Pages\CreateTeacher::route('/create'),
            'edit'   => Pages\EditTeacher::route('/{record}/edit'),
            'book'   => Pages\BookTeacher::route('/{record}/book'),
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
        return __('common.teacher');
    }

    public static function getPluralModelLabel(): string
    {
        return __('common.teachers');
    }
}
