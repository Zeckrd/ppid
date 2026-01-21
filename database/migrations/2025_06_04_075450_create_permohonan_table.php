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
            $table->string('status')->default('Menunggu Verifikasi');
            // Menunggu -> Sedang Diverifikasi ->Diproses -> Selesai
            // Menunggu Verifikasi -> Sedang Diverifikasi -> Perlu Diperbaiki -> RESET -> Menunggu Verifikasi
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
