<?php

namespace App\Filament\Widgets;

use App\Enums\ApplicationStatus;
use App\Models\Application;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestApplications extends TableWidget
{
    protected int|string|array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        return Application::query()->latest('created_at');
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Permohonan Terbaru')
            ->defaultPaginationPageOption(5)
            ->columns([
                TextColumn::make('user.name')->label('Pemohon')->searchable()->wrap(),
                TextColumn::make('opd.nama')->label('OPD')->wrap(),
                TextColumn::make('kategori')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'mahasiswa' => 'Mahasiswa',
                        'smk' => 'PKL SMK',
                        default => $state,
                    }),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        ApplicationStatus::DIPROSES->value => 'Diproses',
                        ApplicationStatus::DISETUJUI->value => 'Disetujui',
                        ApplicationStatus::DITOLAK->value => 'Ditolak',
                        ApplicationStatus::SELESAI->value => 'Selesai',
                        default => $state,
                    }),
                TextColumn::make('created_at')->label('Diajukan')->dateTime('d M Y H:i'),
            ]);
    }
}
