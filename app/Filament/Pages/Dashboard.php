<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\AdminStatsOverview::class,

            \App\Filament\Widgets\ApplicantCategoryChart::class,
            \App\Filament\Widgets\ApplicationStatusChart::class,

            \App\Filament\Widgets\LatestApplications::class,
        ];
    }
}
