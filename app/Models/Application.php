<?php

namespace App\Models;

use App\Enums\ApplicationStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    protected $fillable = [
        'user_id', 'opd_id', 'kategori',
        'institusi', 'jurusan', 'telepon',
        'tanggal_mulai', 'tanggal_selesai',
        'status', 'alasan_penolakan', 'catatan_persetujuan', 'catatan_admin',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function opd(): BelongsTo
    {
        return $this->belongsTo(Opd::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(ApplicationFile::class);
    }

    // public function statusHistories(): HasMany
    // {
    //     return $this->hasMany(ApplicationStatusHistory::class);
    // }

    // Helpers (untuk UI Filament & aturan status)
    public function isDiproses(): bool
    {
        return $this->status === ApplicationStatus::DIPROSES->value;
    }

    public function isDisetujui(): bool
    {
        return $this->status === ApplicationStatus::DISETUJUI->value;
    }

    public function isDitolak(): bool
    {
        return $this->status === ApplicationStatus::DITOLAK->value;
    }

    public function isSelesai(): bool
    {
        return $this->status === ApplicationStatus::SELESAI->value;
    }
}
