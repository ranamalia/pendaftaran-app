<?php

use App\Enums\ApplicationStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('opd_id')->constrained('opds')->restrictOnDelete();

            // kategori: mahasiswa vs smk
            $table->enum('kategori', ['mahasiswa', 'smk']);

            // data pemohon (profil pendaftaran, bukan akun)
            $table->string('institusi'); // kampus/sekolah
            $table->string('jurusan')->nullable();
            $table->string('telepon')->nullable();

            // jadwal
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');

            // status & keputusan
            $table->string('status')->default('diproses');
            // $table->string('status')->default(ApplicationStatus::DIPROSES->value);
            $table->text('alasan_penolakan')->nullable(); // wajib saat ditolak
            $table->text('catatan_persetujuan')->nullable(); // instruksi untuk pemohon
            $table->text('catatan_admin')->nullable(); // internal

            $table->timestamps();

            $table->index(['status', 'kategori']);
            $table->index(['opd_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
