<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('informasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('judul');
            $table->longText('isi');
            $table->enum('jenis', ['info', 'faq'])->default('info');
            $table->timestamps();
            $table->index('jenis');
        });
        Schema::create('rekening', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemilik', 150);
            $table->string('bank', 100);
            $table->string('no_rekening', 50);
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
        Schema::create('arsip_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatan_id')->unique()->constrained('kegiatan')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('judul')->nullable();
            $table->text('ringkasan')->nullable();
            $table->string('berita_acara')->nullable();
            $table->json('dokumentasi')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('arsip_kegiatan');
        Schema::dropIfExists('rekening');
        Schema::dropIfExists('informasi');
    }
};
