<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')->unique()->constrained('pendaftaran')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('kode_pembayaran', 20)->unique();
            $table->timestamp('tgl_kadaluarsa');
            $table->decimal('jumlah_bayar', 12, 0)->nullable();
            $table->enum('status_pembayaran', ['menunggu_pembayaran','menunggu_verifikasi','terverifikasi','ditolak','kadaluarsa'])->default('menunggu_pembayaran');
            $table->string('metode_pembayaran', 50)->nullable();
            $table->string('nama_layanan_bank', 100)->nullable();
            $table->string('nama_pengirim', 150)->nullable();
            $table->string('no_referensi', 100)->nullable();
            $table->text('berita_transaksi')->nullable();
            $table->date('tgl_transfer')->nullable();
            $table->time('jam_transfer')->nullable();
            $table->string('bukti_bayar')->nullable();
            $table->string('no_kwitansi', 50)->nullable()->unique();
            $table->date('tgl_kwitansi')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('pembayaran'); }
};
