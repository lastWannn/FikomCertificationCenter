<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('biaya_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatan_id')->constrained('kegiatan')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('nama_jenis', 100);
            $table->decimal('nominal', 12, 0)->default(0);
            $table->timestamps();
        });
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained('peserta')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('kegiatan_id')->constrained('kegiatan')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('biaya_kegiatan_id')->nullable()->constrained('biaya_kegiatan')->nullOnDelete()->cascadeOnUpdate();
            $table->timestamp('tgl_daftar')->useCurrent();
            $table->enum('status_pendaftaran', ['menunggu_pembayaran','menunggu_verifikasi','terdaftar','ditolak'])->default('menunggu_pembayaran');
            $table->enum('status_kehadiran', ['belum','hadir','tidak_hadir'])->default('belum');
            $table->timestamps();
            $table->unique(['peserta_id','kegiatan_id'], 'uq_peserta_kegiatan');
        });
    }
    public function down(): void {
        Schema::dropIfExists('pendaftaran');
        Schema::dropIfExists('biaya_kegiatan');
    }
};
