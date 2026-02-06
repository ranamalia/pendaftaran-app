<?php

namespace App\Filament\Resources\Applications\Pages;

use App\Filament\Resources\Applications\ApplicationResource;
use App\Models\ApplicationFile;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use App\Enums\ApplicationFileType;
use App\Enums\ApplicationStatus;
use App\Services\ApplicationFileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Support\Str;



class ViewApplication extends ViewRecord
{
    protected static string $resource = ApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // setujui
            Action::make('setujui')
                ->label('Setujui')
                ->color('success')
                ->icon('heroicon-o-check-circle')
                ->requiresConfirmation()
                // ->visible(fn () => $this->record->status === 'diproses')
                ->visible(fn () => $this->record->status === ApplicationStatus::DIPROSES->value)

                ->action(function (): void {
                    $this->record->update([
                        'status' => ApplicationStatus::DISETUJUI->value,
                        'alasan_penolakan' => null,
                    ]);

                    Notification::make()
                        ->title('Permohonan disetujui')
                        ->success()
                        ->send();
                }),

            // tolak
            Action::make('tolak')
                ->label('Tolak')
                ->color('danger')
                ->icon('heroicon-o-x-circle')
                // ->visible(fn () => $this->record->status === 'diproses')
                ->visible(fn () => $this->record->status === ApplicationStatus::DIPROSES->value)

                ->schema([
                    Textarea::make('alasan_penolakan')
                        ->label('Alasan Penolakan')
                        ->required()
                        ->rows(3),
                ])
                ->action(function (array $data): void {
                    $this->record->update([
                        'status' => ApplicationStatus::DITOLAK->value,
                        'alasan_penolakan' => $data['alasan_penolakan'],
                    ]);

                    Notification::make()
                        ->title('Permohonan ditolak')
                        ->danger()
                        ->send();
                }),

            // UPLOAD SURAT JAWABAN (muncul setelah disetujui/ditolak)
            Action::make('uploadSuratJawaban')
                ->label('Upload Surat Jawaban')
                ->icon('heroicon-o-arrow-up-tray')
                ->visible(fn () => in_array($this->record->status, [
                    ApplicationStatus::DISETUJUI->value,
                    ApplicationStatus::DITOLAK->value,
                ], true))
                ->schema([
                    FileUpload::make('file')
                        ->label('Surat Jawaban (PDF)')
                        ->required()
                        ->disk('public')
                        ->directory(fn () => "applications/{$this->record->id}")
                        ->acceptedFileTypes(['application/pdf'])
                        ->maxSize(4096)
                        ->preserveFilenames(false)
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                            $ext = strtolower($file->getClientOriginalExtension() ?: 'pdf');

                            $jenis = ApplicationFileType::SURAT_JAWABAN_IZIN->filenameSlug();
                            $namaPemohon = Str::slug($this->record->user->name);
                            $tanggal = now()->format('Ymd');

                            return "{$jenis}_{$namaPemohon}_{$tanggal}.{$ext}";
                        }),


                ])
                ->action(function (array $data): void {
                    $path = $data['file']; //

                    ApplicationFile::updateOrCreate(
                        [
                            'application_id' => $this->record->id,
                            'type' => ApplicationFileType::SURAT_JAWABAN_IZIN,
                        ],
                        [
                            'path' => $path,
                            'original_name' => basename($path),
                            'uploaded_by' => Auth::user()?->name ?? 'admin',
                        ]
                    );

                    Notification::make()
                        ->title('Surat jawaban berhasil diupload')
                        ->success()
                        ->send();
                }),


            // up surat selesai (muncul saat disetujui/selesai)
            Action::make('uploadSuratSelesai')
                ->label('Upload Surat Selesai')
                ->icon('heroicon-o-arrow-up-tray')
                ->visible(fn () => in_array($this->record->status, [
                    ApplicationStatus::DISETUJUI->value,
                    ApplicationStatus::SELESAI->value,
                ], true))
                ->schema([
                    FileUpload::make('file')
                    ->label('Surat Jawaban (PDF)')
                    ->required()
                    ->disk('public')
                    ->directory(fn () => "applications/{$this->record->id}")
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(4096)
                    ->preserveFilenames(false)
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        $ext = strtolower($file->getClientOriginalExtension() ?: 'pdf');

                        $jenis = ApplicationFileType::SURAT_KETERANGAN_SELESAI->filenameSlug();
                        $namaPemohon = Str::slug($this->record->user->name);
                        $tanggal = now()->format('Ymd');

                        return "{$jenis}_{$namaPemohon}_{$tanggal}.{$ext}";
                    }),


                ])
                ->action(function (array $data): void {
                $path = $data['file'];

                ApplicationFile::updateOrCreate(
                    [
                        'application_id' => $this->record->id,
                        'type' => ApplicationFileType::SURAT_KETERANGAN_SELESAI,
                    ],
                    [
                        'path' => $path,
                        'original_name' => basename($path),
                        'uploaded_by' => Auth::user()?->name ?? 'admin',
                    ]
                );

                Notification::make()
                    ->title('Surat selesai berhasil diupload')
                    ->success()
                    ->send();
            }),


            // SELESAI (  kalau surat selesai sudah ada)
            Action::make('selesai')
                ->label('Tandai Selesai')
                ->color('primary')
                ->icon('heroicon-o-flag')
                ->requiresConfirmation()
                ->visible(function (): bool {
                    if ($this->record->status !== 'disetujui') {
                        return false;
                    }

                    return ApplicationFile::query()
                        ->where('application_id', $this->record->id)
                        ->where('type', ApplicationFileType::SURAT_KETERANGAN_SELESAI->value)
                        ->exists();
                })
                ->action(function (): void {
                    $this->record->update([
                        'status' => ApplicationStatus::SELESAI->value,
                    ]);

                    Notification::make()
                        ->title('Permohonan ditandai selesai')
                        ->success()
                        ->send();
                }),
        ];
    }

    public function getTitle(): string
    {
        return 'Permohonan dari ' . $this->record->user->name;
    }

}
