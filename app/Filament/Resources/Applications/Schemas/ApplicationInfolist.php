<?php

namespace App\Filament\Resources\Applications\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ApplicationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('Nama Pemohon'),

                TextEntry::make('user.email')
                    ->label('Email'),

                TextEntry::make('opd.nama')
                    ->label('OPD Tujuan'),

                TextEntry::make('kategori')
                    ->label('Kategori')
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'mahasiswa' => 'Mahasiswa',
                        'smk' => 'SMK',
                        default => $state,
                    }),

                TextEntry::make('institusi')
                    ->label('Institusi / Sekolah'),

                TextEntry::make('jurusan')
                    ->label('Jurusan')
                    ->placeholder('-'),

                TextEntry::make('telepon')
                    ->label('Telepon')
                    ->placeholder('-'),

                TextEntry::make('tanggal_mulai')
                    ->label('Tanggal Mulai')
                    ->date('d M Y'),

                TextEntry::make('tanggal_selesai')
                    ->label('Tanggal Selesai')
                    ->date('d M Y'),

                TextEntry::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'diproses' => 'Diproses',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                        'selesai' => 'Selesai',
                        default => $state,
                    }),

                TextEntry::make('alasan_penolakan')
                    ->label('Alasan Penolakan')
                    ->placeholder('-'),

                TextEntry::make('catatan_persetujuan')
                    ->label('Catatan Persetujuan')
                    ->placeholder('-'),

                TextEntry::make('catatan_admin')
                    ->label('Catatan Admin')
                    ->placeholder('-'),

                // Metadata (kalau terasa terlalu rame, kamu boleh hapus 2 entry ini)
                TextEntry::make('created_at')
                    ->label('Diajukan')
                    ->dateTime('d M Y H:i'),

                TextEntry::make('updated_at')
                    ->label('Terakhir diubah')
                    ->dateTime('d M Y H:i'),
            ]);
    }
}
