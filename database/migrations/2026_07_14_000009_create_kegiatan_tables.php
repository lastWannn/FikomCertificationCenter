<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_kegiatan', ['pelatihan', 'sertifikasi']);
            $table->string('nama_latar')->nullable();
            $table->timestamps();
        });
        Schema::create('kegiatan_pelatihan', function (Blueprint $table) {
            $table->unsignedBigInteger('kegiatan_id');
            $table->unsignedBigInteger('jadwal_pelatihan_id');
            $table->primary('kegiatan_id');
            $table->unique('jadwal_pelatihan_id');
            $table->foreign('kegiatan_id')->references('id')->on('kegiatan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('jadwal_pelatihan_id')->references('id')->on('jadwal_pelatihan')->onDelete('cascade')->onUpdate('cascade');
        });
        Schema::create('kegiatan_sertifikasi', function (Blueprint $table) {
            $table->unsignedBigInteger('kegiatan_id');
            $table->unsignedBigInteger('jadwal_sertifikasi_id');
            $table->primary('kegiatan_id');
            $table->unique('jadwal_sertifikasi_id');
            $table->foreign('kegiatan_id')->references('id')->on('kegiatan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('jadwal_sertifikasi_id')->references('id')->on('jadwal_sertifikasi')->onDelete('cascade')->onUpdate('cascade');
        });
    }
    public function down(): void {
        Schema::dropIfExists('kegiatan_sertifikasi');
        Schema::dropIfExists('kegiatan_pelatihan');
        Schema::dropIfExists('kegiatan');
    }
};
