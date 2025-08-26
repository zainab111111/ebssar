<?php

namespace App\Filament\Resources\UserLessons\Pages;

use App\Filament\Resources\UserLessons\UserLessonResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUserLesson extends CreateRecord
{
    protected static string $resource = UserLessonResource::class;
}
