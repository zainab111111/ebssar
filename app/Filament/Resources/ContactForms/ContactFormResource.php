<?php

namespace App\Filament\Resources\ContactForms;

use App\Filament\Resources\ContactForms\Pages\CreateContactForm;
use App\Filament\Resources\ContactForms\Pages\EditContactForm;
use App\Filament\Resources\ContactForms\Pages\ListContactForms;
use App\Filament\Resources\ContactForms\Pages\ViewContactForm;
use App\Filament\Resources\ContactForms\Schemas\ContactFormForm;
use App\Filament\Resources\ContactForms\Schemas\ContactFormInfolist;
use App\Filament\Resources\ContactForms\Tables\ContactFormsTable;
use App\Models\ContactForm;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ContactFormResource extends Resource
{
    protected static ?string $model = ContactForm::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'ContactForm';

    public static function form(Schema $schema): Schema
    {
        return ContactFormForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ContactFormInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContactFormsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContactForms::route('/'),
            'view' => ViewContactForm::route('/{record}'),
        ];
    }
}
