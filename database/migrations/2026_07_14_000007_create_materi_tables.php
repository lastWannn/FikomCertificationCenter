<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('materi_pelatihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelatihan_id')->constrained('pelatihan')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('judul_materi');
            $table->string('file_materi')->nullable();
            $table->unsignedTinyInteger('jam_pelajaran')->default(1);
            $table->unsignedTinyInteger('urutan')->default(1);
            $table->timestamps();
        });
        Schema::create('persyaratan_pelatihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelatihan_id')->constrained('pelatihan')->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('deskripsi_syarat');
            $table->unsignedTinyInteger('urutan')->default(1);
            $table->timestamps();
        });
        Schema::create('materi_sertifikasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sertifikasi_id')->constrained('sertifikasi')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('judul_materi');
            $table->text('isi')->nullable();
            $table->string('file_materi')->nullable();
            $table->unsignedTinyInteger('urutan')->default(1);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('materi_sertifikasi');
        Schema::dropIfExists('persyaratan_pelatihan');
        Schema::dropIfExists('materi_pelatihan');
    }
};
