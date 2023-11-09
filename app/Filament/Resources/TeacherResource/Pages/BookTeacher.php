<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use App\Filament\Resources\TeacherResource;
use Filament\Resources\Pages\Page;

class BookTeacher extends Page
{
    protected static string $resource = TeacherResource::class;

    protected static string $view = 'filament.resources.teacher-resource.pages.book-teacher';
}
