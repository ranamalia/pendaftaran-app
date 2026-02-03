<?php

namespace App\Filament\Resources\Applications\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Illuminate\Support\HtmlString;
use App\Enums\ApplicationFileType;

class ApplicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            // INFORMASI PEMOHON
            Section::make('Informasi Pemohon')
                ->icon('heroicon-o-user')
                ->schema([
                    Grid::make(2)->schema([
                        TextEntry::make('user.name')->label('Nama Lengkap'),
                        TextEntry::make('user.email')->label('Email'),
                        TextEntry::make('telepon')->label('Nomor Telepon')->placeholder('-'),
                        TextEntry::make('kategori')
                            ->label('Kategori')
                            ->badge()
                            ->formatStateUsing(fn (?string $state) => ucfirst($state)),
                        TextEntry::make('institusi')->label('Institusi'),
                        TextEntry::make('jurusan')->label('Jurusan / Program Studi')->placeholder('-'),
                    ]),
                ]),

            // OPD & JADWAL
            Section::make('OPD Tujuan & Jadwal')
                ->icon('heroicon-o-building-office')
                ->schema([
                    Grid::make(2)->schema([
                        TextEntry::make('opd.nama')->label('OPD Tujuan'),
                        TextEntry::make('tanggal_mulai')->label('Tanggal Mulai')->date('d F Y'),
                        TextEntry::make('tanggal_selesai')->label('Tanggal Selesai')->date('d F Y'),
                    ]),
                ]),

            // DOKUMEN (TABEL)
    //         Section::make('Dokumen')
    // ->icon('heroicon-o-archive-box-arrow-down')
    // ->schema([
    //     // HEADER (SATU KALI)
    //     Grid::make(4)->schema([
    //         TextEntry::make('header_doc')->label('Nama Dokumen')->state(''),
    //         TextEntry::make('header_by')->label('Diupload Oleh')->state(''),
    //         TextEntry::make('header_date')->label('Tanggal Upload')->state(''),
    //         TextEntry::make('header_action')->label('Aksi')->state(''),
    //     ]),

        // LIST DOKUMEN
    //     RepeatableEntry::make('files')
    //         ->label('') // <-- hilangkan tulisan "Files"
    //         ->visible(fn ($record) => $record->files->isNotEmpty())
    //         ->schema([
    //             Grid::make(4)->schema([
    //                 TextEntry::make('type')
    //                     ->label('') // <-- jangan muncul "Type"
    //                     ->formatStateUsing(function ($state) {
    //                         $value = $state instanceof ApplicationFileType ? $state->value : (string) $state;

    //                         return match ($value) {
    //                             ApplicationFileType::SURAT_PENGANTAR->value => 'Surat Pengantar Kampus',
    //                             ApplicationFileType::PROPOSAL->value => 'Proposal Magang',
    //                             ApplicationFileType::CV->value => 'CV',
    //                             ApplicationFileType::TRANSKRIP_RAPOR->value => 'Transkrip / Rapor',
    //                             ApplicationFileType::SURAT_JAWABAN_IZIN->value => 'Surat Jawaban / Izin Magang',
    //                             ApplicationFileType::SURAT_KETERANGAN_SELESAI->value => 'Surat Keterangan Selesai',
    //                             default => $value,
    //                         };
    //                     }),

    //                 TextEntry::make('uploaded_by')
    //                     ->label('') // <-- jangan muncul "Uploaded by"
    //                     ->placeholder('-'),

    //                 TextEntry::make('created_at')
    //                     ->label('') // <-- jangan muncul "Created at"
    //                     ->date('d M Y'),

    //                 TextEntry::make('path')
    //                     ->label('') // <-- jangan muncul "Path"
    //                     ->formatStateUsing(fn ($state) => new HtmlString(
    //                         '<a href="' . asset('storage/' . ltrim((string) $state, '/')) . '" target="_blank" class="underline text-primary-600">Unduh</a>'
    //                     ))
    //                     ->html(),
    //             ]),
    //         ]),

    //     // JIKA TIDAK ADA DOKUMEN
    //     TextEntry::make('no_files')
    //         ->visible(fn ($record) => $record->files->isEmpty())
    //         ->label(false)
    //         ->state('Belum ada dokumen yang diunggah.'),
    // ]),


            // STATUS & TANGGAL
            Section::make('Status & Catatan')
                ->icon('heroicon-o-clipboard-document-check')
                ->schema([
                    Grid::make(2)->schema([
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn ($state) => match ($state) {
                                'diproses' => 'gray',
                                'disetujui' => 'primary',
                                'ditolak' => 'danger',
                                'selesai' => 'success',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn ($state) => ucfirst($state)),

                        TextEntry::make('created_at')->label('Diajukan')->dateTime('d M Y H:i'),
                        TextEntry::make('updated_at')->label('Terakhir Diubah')->dateTime('d M Y H:i'),

                        TextEntry::make('alasan_penolakan')->label('Alasan Penolakan')->placeholder('-'),
                        TextEntry::make('catatan_persetujuan')->label('Catatan Persetujuan')->placeholder('-'),
                        TextEntry::make('catatan_admin')->label('Catatan Admin')->placeholder('-'),
                    ]),
                ]),
        ]);
    }
}
