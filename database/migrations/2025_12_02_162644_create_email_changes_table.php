<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('email_changes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('new_email');
            $table->string('token_hash')->unique();

            $table->timestamp('expires_at')->nullable();
            $table->timestamp('last_sent_at')->nullable();

            $table->timestamps();

            $table->unique('user_id');
            $table->index('expires_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('email_changes');
    }

};
