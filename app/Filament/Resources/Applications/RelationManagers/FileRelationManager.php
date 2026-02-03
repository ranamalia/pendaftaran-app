<?php

namespace App\Filament\Resources\Applications\RelationManagers;

use App\Enums\ApplicationFileType;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

class FilesRelationManager extends RelationManager
{
    protected static string $relationship = 'files';

    protected static ?string $title = 'Dokumen';

    public function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->columns([
                TextColumn::make('type')
                    ->label('Nama Dokumen')
                    ->formatStateUsing(function ($state) {
                        $value = $state instanceof ApplicationFileType ? $state->value : (string) $state;

                        return match ($value) {
                            ApplicationFileType::SURAT_PENGANTAR->value => 'Surat Pengantar Kampus',
                            ApplicationFileType::PROPOSAL->value => 'Proposal Magang',
                            ApplicationFileType::CV->value => 'CV',
                            ApplicationFileType::TRANSKRIP_RAPOR->value => 'Transkrip / Rapor',
                            ApplicationFileType::SURAT_JAWABAN_IZIN->value => 'Surat Jawaban / Izin Magang',
                            ApplicationFileType::SURAT_KETERANGAN_SELESAI->value => 'Surat Keterangan Selesai',
                            default => $value,
                        };
                    })
                    ->wrap()
                    ->extraAttributes(['class' => 'w-[55%]']),

                TextColumn::make('uploaded_by')
                    ->label('Diupload Oleh')
                    ->placeholder('-')
                    ->extraAttributes(['class' => 'w-[15%]']),

                TextColumn::make('created_at')
                    ->label('Tanggal Upload')
                    ->date('d/m/Y')
                    ->extraAttributes(['class' => 'w-[15%]']),

                TextColumn::make('aksi')
                    ->label('Aksi')
                    ->state(function ($record) {
                        $url = Storage::url($record->path);

                        return new HtmlString(
                            '<a href="' . e($url) . '" target="_blank"
                                class="inline-flex items-center gap-1 rounded-md border px-3 py-1 text-sm font-medium hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Lihat
                            </a>'
                        );
                    })
                    ->html()
                    ->alignCenter()
                    ->extraAttributes(['class' => 'w-[15%] whitespace-nowrap']),
            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([])
            ->emptyStateHeading('Belum ada dokumen');
    }
}
