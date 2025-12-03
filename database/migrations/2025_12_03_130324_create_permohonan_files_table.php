<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permohonan_files', function (Blueprint $table) {
            $table->id();

            $table->foreignId('permohonan_id')
                ->constrained('permohonan')
                ->onDelete('cascade'); // delete files when permohonan deleted

            $table->string('path');              // storage path
            $table->string('original_name');     // filename from user
            $table->unsignedBigInteger('size')->nullable();       // bytes
            $table->string('mime_type', 100)->nullable();         // mime type

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permohonan_files');
    }
};
