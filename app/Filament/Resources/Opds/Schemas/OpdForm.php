<?php

namespace App\Filament\Resources\Opds\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class OpdForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Nama OPD')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                TextInput::make('kode')
                    ->label('Kode OPD')
                    ->maxLength(50)
                    ->helperText('Opsional. Contoh: DISKOMINFO, DISPORA, DLL.')
                    ->dehydrateStateUsing(
                        fn (?string $state) => $state ? strtoupper(trim($state)) : null
                    ),

                Toggle::make('aktif')
                    ->label('Aktif')
                    ->default(true)
                    ->required(),

                TextInput::make('kontak')
                    ->label('Kontak')
                    ->maxLength(255)
                    ->helperText('Nomor HP / email admin OPD')
                    ->columnSpanFull(),

                Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->rows(4)
                    ->maxLength(1000)
                    ->columnSpanFull(),
            ]);
    }
}
