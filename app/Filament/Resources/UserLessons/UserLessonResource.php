<?php

namespace App\Filament\Resources\UserLessons;

use App\Filament\Resources\UserLessons\Pages\CreateUserLesson;
use App\Filament\Resources\UserLessons\Pages\EditUserLesson;
use App\Filament\Resources\UserLessons\Pages\ListUserLessons;
use App\Filament\Resources\UserLessons\Schemas\UserLessonForm;
use App\Filament\Resources\UserLessons\Tables\UserLessonsTable;
use App\Models\UserLesson;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserLessonResource extends Resource
{
    protected static ?string $model = UserLesson::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return UserLessonForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserLessonsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationSort(): int
    {
        return 5;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUserLessons::route('/'),
            'create' => CreateUserLesson::route('/create'),
            'edit' => EditUserLesson::route('/{record}/edit'),
        ];
    }
}
