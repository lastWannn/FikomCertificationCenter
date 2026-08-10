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
        Schema::create('pesan_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->string('email', 150);
            $table->text('pesan');
            $table->enum('status', ['belum_dibaca', 'dibaca', 'dibalas'])->default('belum_dibaca');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesan_masuk');
    }
};
