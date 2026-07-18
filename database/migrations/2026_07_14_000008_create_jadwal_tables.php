<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('jadwal_pelatihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelatihan_id')->constrained('pelatihan')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('nama_kegiatan', 255)->nullable();
            $table->string('nama_jenis_biaya', 100)->nullable();
            $table->decimal('nominal_biaya', 12, 0)->nullable();
            $table->unsignedSmallInteger('kuota_peserta');
            $table->enum('untuk_peserta', ['L', 'P', 'LP'])->default('LP');
            $table->date('tgl_batas_daftar');
            $table->date('tgl_pelaksanaan');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->timestamps();
        });
        Schema::create('jadwal_sertifikasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sertifikasi_id')->constrained('sertifikasi')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('nama_kegiatan', 255)->nullable();
            $table->string('nama_jenis_biaya', 100)->nullable();
            $table->decimal('nominal_biaya', 12, 0)->nullable();
            $table->unsignedSmallInteger('kuota_peserta');
            $table->enum('untuk_peserta', ['L', 'P', 'LP'])->default('LP');
            $table->date('tgl_batas_daftar');
            $table->date('tgl_pelaksanaan');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('jadwal_sertifikasi');
        Schema::dropIfExists('jadwal_pelatihan');
    }
};
