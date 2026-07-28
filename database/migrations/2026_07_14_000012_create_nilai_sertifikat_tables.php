<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('materi_pelatihan_id')->nullable()->constrained('materi_pelatihan')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('materi_sertifikasi_id')->nullable()->constrained('materi_sertifikasi')->nullOnDelete()->cascadeOnUpdate();
            $table->decimal('nilai', 5, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('sertifikat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->unique()->constrained('pendaftaran')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('nomor_sertifikat', 100)->unique();
            $table->string('file_sertifikat')->nullable();
            $table->string('gambar_latar')->nullable();
            $table->date('tgl_terbit');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('sertifikat');
        Schema::dropIfExists('nilai');
    }
};
