<?php

namespace App\Filament\Resources\Applications;

use App\Filament\Resources\Applications\Pages\CreateApplication;
use App\Filament\Resources\Applications\Pages\EditApplication;
use App\Filament\Resources\Applications\Pages\ListApplications;
use App\Filament\Resources\Applications\Pages\ViewApplication;
use App\Filament\Resources\Applications\Schemas\ApplicationForm;
use App\Filament\Resources\Applications\Schemas\ApplicationInfolist;
use App\Filament\Resources\Applications\Tables\ApplicationsTable;
use App\Models\Application;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Filament\Resources\Applications\RelationManagers\FilesRelationManager;


class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;


    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $navigationLabel= 'Permohonan';
    protected static ?string $modelLabel= 'Permohonan';
    protected static ?string $pluralModelLabel= 'Permohonan';
    protected static ?int $navigationSort= 1;

    public static function form(Schema $schema): Schema
    {
        return ApplicationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ApplicationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ApplicationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            FilesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListApplications::route('/'),
            // 'create' => CreateApplication::route('/create'),
            'view' => ViewApplication::route('/{record}'),
            // 'edit' => EditApplication::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->with(['user', 'opd', 'files']);
    }
}
