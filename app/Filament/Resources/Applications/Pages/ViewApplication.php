<?php

namespace App\Filament\Resources\Applications\Pages;

use App\Filament\Resources\Applications\ApplicationResource;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewApplication extends ViewRecord
{
    protected static string $resource = ApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // SETUJUI
            Action::make('setujui')
                ->label('Setujui')
                ->color('success')
                ->icon('heroicon-o-check-circle')
                ->requiresConfirmation()
                ->visible(fn () => $this->record->status === 'diproses')
                ->action(function () {
                    $this->record->update([
                        'status' => 'disetujui',
                        'alasan_penolakan' => null,
                    ]);

                    Notification::make()
                        ->title('Permohonan disetujui')
                        ->success()
                        ->send();
                }),

            // TOLAK
            Action::make('tolak')
                ->label('Tolak')
                ->color('danger')
                ->icon('heroicon-o-x-circle')
                ->visible(fn () => $this->record->status === 'diproses')
                ->form([
                    \Filament\Forms\Components\Textarea::make('alasan_penolakan')
                        ->label('Alasan Penolakan')
                        ->required()
                        ->rows(3),
                ])
                ->action(function (array $data) {
                    $this->record->update([
                        'status' => 'ditolak',
                        'alasan_penolakan' => $data['alasan_penolakan'],
                    ]);

                    Notification::make()
                        ->title('Permohonan ditolak')
                        ->danger()
                        ->send();
                }),

            // SELESAI
            Action::make('selesai')
                ->label('Tandai Selesai')
                ->color('primary')
                ->icon('heroicon-o-flag')
                ->requiresConfirmation()
                ->visible(fn () => $this->record->status === 'disetujui')
                ->action(function () {
                    $this->record->update([
                        'status' => 'selesai',
                    ]);

                    Notification::make()
                        ->title('Permohonan ditandai selesai')
                        ->success()
                        ->send();
                }),
        ];
    }
}
