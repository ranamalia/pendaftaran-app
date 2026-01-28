<?php

namespace App\Filament\Resources\Applications\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Pemohon')
                    ->relationship('user', 'name')
                    ->required()
                    ->disabled(),
                Select::make('opd_id')
                    ->label('OPD Tujuan')
                    ->relationship('opd', 'id')
                    ->required()
                    ->disabled(),
                Select::make('kategori')
                    ->label('Kategori')
                    ->options(['mahasiswa' => 'Mahasiswa', 'smk' => 'SMK'])
                    ->required()
                    ->disabled(),
                TextInput::make('institusi')
                    ->label('Institusi/Sekolah')
                    ->required()
                    ->maxLength(255)
                    ->disabled(),
                TextInput::make('jurusan')
                    ->label('Jurusan')
                    ->maxLength(255)
                    ->disabled(),
                TextInput::make('telepon')
                    ->label('Telepon')
                    ->tel()
                    ->maxLength(50)
                    ->disabled(),
                DatePicker::make('tanggal_mulai')
                    ->label('Tanggal Mulai')
                    ->disabled()
                    ->required(),
                DatePicker::make('tanggal_selesai')
                    ->label('Tanggal Selesai')
                    ->required()
                    ->disabled(),
                TextInput::make('status')
                    ->label('Status')
                    ->options([
                        'diproses' => 'Diproses',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                        'selesai' => 'Selesai',
                    ])
                    ->required()
                    ->default('diproses'),
                Textarea::make('alasan_penolakan')
                    ->label('Alasan Penolakan')
                    ->rows(3)
                    ->maxLength(1000)
                    ->columnSpanFull(),
                Textarea::make('catatan_persetujuan')
                    ->label('Catatan Persetujuan')
                    ->rows(3)
                    ->maxLength(1000)
                    ->columnSpanFull(),
                Textarea::make('catatan_admin')
                    ->label('Catatan Admin')
                    ->rows(3)
                    ->maxLength(1000)
                    ->columnSpanFull(),
            ]);
    }
}
