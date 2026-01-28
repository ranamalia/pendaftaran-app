<?php

namespace App\Filament\Resources\Applications\Pages;

use App\Filament\Resources\Applications\ApplicationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListApplications extends ListRecords
{
    protected static string $resource = ApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }

    protected function getTableEmptyStateHeading(): ?string
{
    return 'Belum ada permohonan';
}

protected function getTableEmptyStateDescription(): ?string
{
    return 'Permohonan magang / PKL dari user akan muncul di sini.';
}

}
