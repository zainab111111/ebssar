<?php

namespace App\Filament\Resources\UserLessons\Pages;

use App\Filament\Resources\UserLessons\UserLessonResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUserLessons extends ListRecords
{
    protected static string $resource = UserLessonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
