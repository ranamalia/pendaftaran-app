<?php

namespace App\Enums;

enum ApplicationStatus: string
{
    case DIPROSES = 'diproses';
    case DISETUJUI = 'disetujui';
    case DITOLAK = 'ditolak';
    case SELESAI = 'selesai';
}
