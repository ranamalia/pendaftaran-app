<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('pemohon_tipe')->nullable()->index(); // smk|mahasiswa
            $table->string('no_hp')->nullable();
            $table->text('alamat')->nullable();

            $table->string('instansi_nama')->nullable(); // sekolah/kampus
            $table->string('jurusan')->nullable();
            $table->string('nomor_induk')->nullable(); // NISN/NIM
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'pemohon_tipe','no_hp','alamat','instansi_nama','jurusan','nomor_induk'
            ]);
        });
    }
};
