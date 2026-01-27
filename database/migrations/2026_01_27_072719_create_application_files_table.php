<?php

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
        Schema::create('application_files', function (Blueprint $table) {
            $table->id();

            $table->foreignId('application_id')->constrained('applications')->cascadeOnDelete();

            // tipe dokumen
            $table->string('type'); // pakai enum value dari ApplicationFileType

            // storage path
            $table->string('path');
            $table->string('original_name')->nullable();

            // siapa yang upload
            $table->enum('uploaded_by', ['user', 'admin'])->default('user');

            $table->timestamps();

            $table->unique(['application_id', 'type']); // 1 jenis dokumen per permohonan (bisa kamu ubah kalau butuh multi)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_files');
    }
};
