<?php

namespace App\Filament\Resources\Applications\Tables;

use App\Enums\ApplicationFileType;
use App\Enums\ApplicationStatus;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class ApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Pemohon')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('opd.nama')
                    ->label('OPD')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('kategori')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'mahasiswa' => 'Mahasiswa',
                        'smk' => 'SMK',
                        default => $state,
                    })
                    ->sortable(),

                TextColumn::make('institusi')
                    ->label('Institusi')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('tanggal_mulai')
                    ->label('Mulai')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('tanggal_selesai')
                    ->label('Selesai')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        ApplicationStatus::DIPROSES->value => 'Diproses',
                        ApplicationStatus::DISETUJUI->value => 'Disetujui',
                        ApplicationStatus::DITOLAK->value => 'Ditolak',
                        ApplicationStatus::SELESAI->value => 'Selesai',
                        default => $state,
                    })
                    ->color(fn (?string $state) => match ($state) {
                        ApplicationStatus::DIPROSES->value => 'warning', // kuning
                        ApplicationStatus::DISETUJUI->value => 'success', // hijau
                        ApplicationStatus::DITOLAK->value => 'danger', // merah
                        ApplicationStatus::SELESAI->value => 'primary', // biru
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('surat_jawaban')
                    ->label('Surat Jawaban')
                    ->state(function ($record) {
                        $file = $record->files()->where('type', ApplicationFileType::SURAT_JAWABAN_IZIN->value)->first();
                        return $file ? 'Ada' : '-';
                    })
                    ->url(function ($record) {
                        $file = $record->files()->where('type', ApplicationFileType::SURAT_JAWABAN_IZIN->value)->first();
                        return $file?->path ? asset('storage/' . ltrim($file->path, '/')) : null;
                    })
                    ->openUrlInNewTab()
                    ->badge(),

                TextColumn::make('surat_selesai')
                    ->label('Surat Selesai')
                    ->state(function ($record) {
                        $file = $record->files()->where('type', ApplicationFileType::SURAT_KETERANGAN_SELESAI->value)->first();
                        return $file ? 'Ada' : '-';
                    })
                    ->url(function ($record) {
                        $file = $record->files()->where('type', ApplicationFileType::SURAT_KETERANGAN_SELESAI->value)->first();
                        return $file?->path ? asset('storage/' . ltrim($file->path, '/')) : null;
                    })
                    ->openUrlInNewTab()
                    ->badge(),

                TextColumn::make('created_at')
                    ->label('Diajukan')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diubah')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        ApplicationStatus::DIPROSES->value => 'Diproses',
                        ApplicationStatus::DISETUJUI->value => 'Disetujui',
                        ApplicationStatus::DITOLAK->value => 'Ditolak',
                        ApplicationStatus::SELESAI->value => 'Selesai',
                    ]),

                SelectFilter::make('kategori')
                    ->label('Kategori')
                    ->options([
                        'mahasiswa' => 'Mahasiswa',
                        'smk' => 'SMK',
                    ]),

                SelectFilter::make('opd_id')
                    ->label('OPD')
                    ->relationship('opd', 'nama'),

            ])

            ->recordActions([
                ViewAction::make(),

                ActionGroup::make([
                    Action::make('batalkanSuratJawaban')
                        ->label('Batalkan Surat Jawaban')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->visible(fn ($record): bool =>
                            $record->files()->where('type', ApplicationFileType::SURAT_JAWABAN_IZIN->value)->exists()
                        )
                        ->action(function ($record): void {
                            $file = $record->files()->where('type', ApplicationFileType::SURAT_JAWABAN_IZIN->value)->first();

                            if (! $file) return;

                            if ($file->path) {
                                Storage::disk('public')->delete($file->path);
                            }

                            $file->delete();

                            Notification::make()
                                ->title('Surat jawaban dibatalkan')
                                ->success()
                                ->send();
                        }),

                    Action::make('batalkanSuratSelesai')
                        ->label('Batalkan Surat Selesai')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->visible(fn ($record): bool =>
                            $record->files()->where('type', ApplicationFileType::SURAT_KETERANGAN_SELESAI->value)->exists()
                        )
                        ->action(function ($record): void {
                            $file = $record->files()->where('type', ApplicationFileType::SURAT_KETERANGAN_SELESAI->value)->first();

                            if (! $file) return;

                            if ($file->path) {
                                Storage::disk('public')->delete($file->path);
                            }

                            $file->delete();

                            // kalau status sudah selesai, balikin agar konsisten
                            if ($record->status === ApplicationStatus::SELESAI->value) {
                                $record->update(['status' => ApplicationStatus::DISETUJUI->value]);
                            }

                            Notification::make()
                                ->title('Surat selesai dibatalkan')
                                ->success()
                                ->send();
                        }),
                ])->label('Aksi Lainnya'),
            ])
            ->toolbarActions([
                // Saran: disable bulk delete biar aman
            ]);
    }
}
