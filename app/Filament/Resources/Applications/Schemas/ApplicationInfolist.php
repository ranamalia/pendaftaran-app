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
            // info pemohon
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

            // opd & jadwal
            Section::make('OPD Tujuan & Jadwal')
                ->icon('heroicon-o-building-office')
                ->schema([
                    Grid::make(2)->schema([
                        TextEntry::make('opd.nama')->label('OPD Tujuan'),
                        TextEntry::make('tanggal_mulai')->label('Tanggal Mulai')->date('d F Y'),
                        TextEntry::make('tanggal_selesai')->label('Tanggal Selesai')->date('d F Y'),
                    ]),
                ]),


            // Status & tanggal
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
