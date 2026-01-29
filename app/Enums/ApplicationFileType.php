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
}
