<?php

namespace App\Filament\Widgets;

use App\Enums\ApplicationStatus;
use App\Models\Application;
use App\Models\Opd;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends StatsOverviewWidget
{
    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Permohonan', Application::query()->count())
                ->description('Semua permohonan masuk'),

            Stat::make('Diproses', Application::query()->where('status', ApplicationStatus::DIPROSES->value)->count())
                ->description('Menunggu verifikasi'),

            Stat::make('Disetujui', Application::query()->where('status', ApplicationStatus::DISETUJUI->value)->count())
                ->description('Sudah disetujui'),

            Stat::make('Ditolak', Application::query()->where('status', ApplicationStatus::DITOLAK->value)->count())
                ->description('Permohonan ditolak'),

            Stat::make('Selesai', Application::query()->where('status', ApplicationStatus::SELESAI->value)->count())
                ->description('Sudah selesai'),

            Stat::make('Total OPD', Opd::query()->count())
                ->description('OPD terdaftar'),
        ];
    }
}
