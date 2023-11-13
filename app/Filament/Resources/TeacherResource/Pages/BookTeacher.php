<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use App\Filament\Resources\TeacherResource;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class BookTeacher extends Page
{
    use InteractsWithRecord;

    public static bool $shouldRegisterNavigation = false;

    protected static string $resource = TeacherResource::class;

    protected static string $view = 'filament.resources.teacher-resource.pages.book-teacher';

    public ?string $previousUrl = null;

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $this->authorizeAccess();

        $this->previousUrl = url()->previous();
    }

    protected function authorizeAccess(): void
    {
        static::authorizeResourceAccess();

//        abort_unless(static::getResource()::canEdit($this->getRecord()), 403);
    }
}
