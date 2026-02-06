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

    
    protected function getColumns(): int
    {
        return 3;
    }

    protected function getStats(): array
    {
        $total = Application::query()->count();

        $diproses  = Application::query()->where('status', ApplicationStatus::DIPROSES->value)->count();
        $disetujui = Application::query()->where('status', ApplicationStatus::DISETUJUI->value)->count();
        $ditolak   = Application::query()->where('status', ApplicationStatus::DITOLAK->value)->count();
        $selesai   = Application::query()->where('status', ApplicationStatus::SELESAI->value)->count();

        return [
            Stat::make('Total Permohonan', $total)
                ->description('Semua permohonan masuk')
                ->icon('heroicon-o-inbox')
                ->color('gray'),

            Stat::make('Diproses', $diproses)
                ->description('Menunggu verifikasi')
                ->icon('heroicon-o-clock')
                ->color('info'),

            Stat::make('Disetujui', $disetujui)
                ->description('Sudah disetujui')
                ->icon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Ditolak', $ditolak)
                ->description('Permohonan ditolak')
                ->icon('heroicon-o-x-circle')
                ->color('danger'),

            Stat::make('Selesai', $selesai)
                ->description('Sudah selesai')
                ->icon('heroicon-o-flag')
                ->color('primary'),

            Stat::make('Total OPD', Opd::query()->count())
                ->description('OPD terdaftar')
                ->icon('heroicon-o-building-office-2')
                ->color('warning'),
        ];
    }
}
