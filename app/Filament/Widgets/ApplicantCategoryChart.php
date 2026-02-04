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

    public function mount(): void
    {
        parent::mount();

        $data = $this->getData();
        $total = array_sum($data['datasets'][0]['data'] ?? []);
        $this->heading = "Kategori Pemohon";
        $this->description = "Total: {$total}";
    }

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

        $mahasiswa = (int) ($row->mahasiswa ?? 0);
        $smk = (int) ($row->smk ?? 0);

        // update heading setiap kali data dihitung
        $this->heading = "Kategori Pemohon ";
        $this->description = "(Total: " . ($mahasiswa + $smk) . ")";

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah',
                    'data' => [$mahasiswa, $smk],
                    'backgroundColor' => ['#3B82F6', '#F59E0B'],
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
            'cutout' => '68%',
            'hoverOffset' => 10,
        ];
    }
}
