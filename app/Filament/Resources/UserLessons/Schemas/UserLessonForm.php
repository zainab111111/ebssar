<?php

namespace App\Filament\Resources\UserLessons\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserLessonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('lesson_id')
                    ->relationship('lesson', 'title')
                    ->required(),
                TextInput::make('is_completed')
                    ->required(),
            ]);
    }
}
