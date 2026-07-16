<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('konten_halaman', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis', ['beranda','tentang_kami','visi_misi_tujuan','tata_cara_pendaftaran'])->unique();
            $table->string('judul');
            $table->longText('isi');
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
        Schema::create('mitra', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mitra', 200);
            $table->string('inisial', 10)->nullable()->comment('Singkatan untuk logo placeholder');
            $table->string('warna', 20)->nullable()->comment('Warna hex bg logo');
            $table->string('logo')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('link_website', 500)->nullable();
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->timestamps();
        });
        Schema::create('kontak', function (Blueprint $table) {
            $table->id();
            $table->text('alamat');
            $table->string('telepon', 20);
            $table->string('email', 150);
            $table->text('maps_embed')->nullable()->comment('iframe embed Google Maps');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('kontak');
        Schema::dropIfExists('mitra');
        Schema::dropIfExists('konten_halaman');
    }
};
