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
        Schema::create('permohonan', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class);
            $table->enum('permohonan_type', ['biasa', 'khusus'])->default('biasa');
            $table->string('status')->default('Menunggu Verifikasi Berkas Dari Petugas');
            // Menunggu Verifikasi Berkas Dari Petugas -> Sedang Diverifikasi petugas -> Permohonan Sedang Diproses -> Selesai
            // Menunggu Verifikasi Berkas Dari Petugas -> Sedang Diverifikasi petugas -> Perlu Diperbaiki -> RESET -> Menunggu Verifikasi Berkas Dari Petugas
            $table->text('keterangan_user');
            $table->text('keterangan_petugas')->nullable();
            $table->string('reply_file')->nullable();
            $table->enum('reply_type', ['softcopy', 'hardcopy'])->default('softcopy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonan');
    }
};
