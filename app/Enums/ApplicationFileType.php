<?php

namespace App\Enums;

enum ApplicationFileType: string
{
    // Dokumen dari pemohon (user)
    case SURAT_PENGANTAR = 'surat_pengantar';
    case PROPOSAL = 'proposal';
    case CV = 'cv';
    case TRANSKRIP_RAPOR = 'transkrip_rapor';

    // Dokumen dari admin
    case SURAT_JAWABAN_IZIN = 'surat_jawaban_izin';
    case SURAT_KETERANGAN_SELESAI = 'surat_keterangan_selesai';

    case SURAT_JAWABAN = 'surat_jawaban';
    case SURAT_SELESAI = 'surat_selesai';

    public function label(): string
    {
        return match ($this) {
            self::SURAT_PENGANTAR => 'Surat Pengantar Kampus',
            self::PROPOSAL => 'Proposal Magang',
            self::CV => 'CV',
            self::TRANSKRIP_RAPOR => 'Transkrip / Rapor',
            self::SURAT_JAWABAN_IZIN,
            self::SURAT_JAWABAN => 'Surat Jawaban / Izin Magang',
            self::SURAT_KETERANGAN_SELESAI,
            self::SURAT_SELESAI => 'Surat Keterangan Selesai',
        };
    }

    public function filenameSlug(): string
    {
        return match ($this) {
            self::SURAT_PENGANTAR => 'surat-pengantar',
            self::PROPOSAL => 'proposal',
            self::CV => 'cv',
            self::TRANSKRIP_RAPOR => 'transkrip-rapor',
            self::SURAT_JAWABAN_IZIN,
            self::SURAT_JAWABAN => 'surat-jawaban',
            self::SURAT_KETERANGAN_SELESAI,
            self::SURAT_SELESAI => 'surat-selesai',
        };
    }

    public function isAdminFile(): bool
    {
        return in_array($this, [
            self::SURAT_JAWABAN_IZIN,
            self::SURAT_KETERANGAN_SELESAI,
            self::SURAT_JAWABAN,
            self::SURAT_SELESAI,
        ], true);
    }
}
