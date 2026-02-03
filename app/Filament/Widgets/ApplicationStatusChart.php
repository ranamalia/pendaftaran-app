<?php

namespace App\Filament\Widgets;

use App\Enums\ApplicationStatus;
use App\Models\Application;
use App\Models\Opd;
use Filament\Widgets\ChartWidget;

class ApplicationStatusChart extends ChartWidget
{
    protected ?string $heading = 'Status Permohonan';

    protected int|string|array $columnSpan = 1;
    protected ?string $maxHeight = '220px';

    protected function getFilters(): ?array
    {
        return Opd::query()
            ->orderBy('nama')
            ->pluck('nama', 'id')
            ->prepend('Semua OPD', 'all')
            ->toArray();
    }

    protected function getData(): array
    {
        $query = Application::query();

        if (($this->filter ?? 'all') !== 'all') {
            $query->where('opd_id', $this->filter);
        }

        $row = $query->selectRaw("
            SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) AS diproses,
            SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) AS disetujui,
            SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) AS ditolak,
            SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) AS selesai
        ", [
            ApplicationStatus::DIPROSES->value,
            ApplicationStatus::DISETUJUI->value,
            ApplicationStatus::DITOLAK->value,
            ApplicationStatus::SELESAI->value,
        ])->first();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah',
                    'data' => [
                        (int) ($row->diproses ?? 0),
                        (int) ($row->disetujui ?? 0),
                        (int) ($row->ditolak ?? 0),
                        (int) ($row->selesai ?? 0),
                    ],
                    'backgroundColor' => [
                        '#3B82F6', // Diproses - Biru
                        '#22C55E', // Disetujui - Hijau
                        '#EF4444', // Ditolak - Merah
                        '#64748B', // Selesai - Abu gelap
                    ],
                    'borderWidth' => 0,
                ],
            ],
            'labels' => ['Diproses', 'Disetujui', 'Ditolak', 'Selesai'],
        ];

    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'usePointStyle' => true,
                    ],
                ],
            ],
            'cutout' => '65%',
            'hoverOffset' => 8,
        ];
    }

}
