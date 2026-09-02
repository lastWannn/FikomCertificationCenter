<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tanda_tangan', function (Blueprint $table) {
            $table->id();

            // 1. Tanda Tangan Dekan (Sertifikat Kiri)
            $table->string('dekan_nama')->nullable()->default('Purnawansyah');
            $table->string('dekan_jabatan')->nullable()->default('DEKAN');
            $table->string('dekan_nip')->nullable();
            $table->string('dekan_ttd')->nullable();

            // 2. Tanda Tangan Ketua Unit (Sertifikat Kanan)
            $table->string('ketua_nama')->nullable()->default("Abdul Rachman Manga'");
            $table->string('ketua_jabatan')->nullable()->default('KETUA UNIT');
            $table->string('ketua_nip')->nullable();
            $table->string('ketua_ttd')->nullable();

            // 3. Tanda Tangan Bendahara / Keuangan (Invoice & Kwitansi)
            $table->string('bendahara_nama')->nullable()->default('Panitia FCC');
            $table->string('bendahara_jabatan')->nullable()->default('BENDAHARA / KEUANGAN');
            $table->string('bendahara_nip')->nullable();
            $table->string('bendahara_ttd')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tanda_tangan');
    }
};
