<?php

namespace App\Services;

use App\Enums\ApplicationStatus;
use App\Models\Application;
use App\Models\ApplicationStatusHistory;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ApplicationService
{
    public function approve(Application $app, User $admin, ?string $catatanPersetujuan = null): Application
    {
        return DB::transaction(function () use ($app, $admin, $catatanPersetujuan) {
            $from = $app->status;

            $app->update([
                'status' => ApplicationStatus::DISETUJUI->value,
                'catatan_persetujuan' => $catatanPersetujuan,
                'alasan_penolakan' => null,
            ]);

            // ApplicationStatusHistory::create([
            //     'application_id' => $app->id,
            //     'from_status' => $from,
            //     'to_status' => $app->status,
            //     'changed_by_user_id' => $admin->id,
            //     'note' => $catatanPersetujuan,
            // ]);

            return $app->refresh();
        });
    }

    // public function reject(Application $app, User $admin, string $alasan): Application
    // {
    //     return DB::transaction(function () use ($app, $admin, $alasan) {
    //         $from = $app->status;

    //         $app->update([
    //             'status' => ApplicationStatus::DITOLAK->value,
    //             'alasan_penolakan' => $alasan,
    //             'catatan_persetujuan' => null,
    //         ]);

    //         ApplicationStatusHistory::create([
    //             'application_id' => $app->id,
    //             'from_status' => $from,
    //             'to_status' => $app->status,
    //             'changed_by_user_id' => $admin->id,
    //             'note' => $alasan,
    //         ]);

    //         return $app->refresh();
    //     });
    // }

    // public function markFinished(Application $app, User $admin, ?string $note = null): Application
    // {
    //     return DB::transaction(function () use ($app, $admin, $note) {
    //         $from = $app->status;

    //         $app->update([
    //             'status' => ApplicationStatus::SELESAI->value,
    //         ]);

    //         ApplicationStatusHistory::create([
    //             'application_id' => $app->id,
    //             'from_status' => $from,
    //             'to_status' => $app->status,
    //             'changed_by_user_id' => $admin->id,
    //             'note' => $note,
    //         ]);

    //         return $app->refresh();
    //     });
    // }

    // public function saveAdminNote(Application $app, User $admin, ?string $catatanAdmin): Application
    // {
    //     return DB::transaction(function () use ($app, $admin, $catatanAdmin) {
    //         $app->update(['catatan_admin' => $catatanAdmin]);

    //         // kalau mau catatan admin juga masuk timeline, boleh catat di history dengan to_status = status sekarang
    //         // ApplicationStatusHistory::create([
    //         //     'application_id' => $app->id,
    //         //     'from_status' => null,
    //         //     'to_status' => $app->status,
    //         //     'changed_by_user_id' => $admin->id,
    //         //     'note' => $catatanAdmin ? ('Catatan admin: ' . $catatanAdmin) : null,
    //         // ]);

    //         return $app->refresh();
    //     });
    // }
}
