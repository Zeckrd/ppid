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
        Schema::create('keberatan', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Permohonan::class)->constrained()->onDelete('cascade');
            $table->string('keberatan_file');
            $table->enum('status', ['Pending','Diproses', 'Diterima','Ditolak'])->default('Pending');
            $table->text('keterangan_user');
            $table->text('keterangan_petugas')->nullable();
            $table->string('reply_file')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keberatan');
    }
};
