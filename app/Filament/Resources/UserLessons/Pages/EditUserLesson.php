<?php

namespace App\Filament\Resources\UserLessons\Pages;

use App\Filament\Resources\UserLessons\UserLessonResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUserLesson extends EditRecord
{
    protected static string $resource = UserLessonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
