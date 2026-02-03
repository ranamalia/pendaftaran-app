<?php

namespace App\Filament\Widgets;

use App\Models\Application;
use App\Models\Opd;
use Filament\Widgets\ChartWidget;

class ApplicantCategoryChart extends ChartWidget
{
    protected ?string $heading = 'Kategori Pemohon';

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
            SUM(CASE WHEN kategori = 'mahasiswa' THEN 1 ELSE 0 END) AS mahasiswa,
            SUM(CASE WHEN kategori = 'smk' THEN 1 ELSE 0 END) AS smk
        ")->first();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah',
                    'data' => [
                        (int) ($row->mahasiswa ?? 0),
                        (int) ($row->smk ?? 0),
                    ],
                    'backgroundColor' => [
                        '#3B82F6',
                        '#F59E0B',
                    ],
                    'borderWidth' => 0,
                ],
            ],
            'labels' => ['Mahasiswa', 'PKL SMK'],
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
