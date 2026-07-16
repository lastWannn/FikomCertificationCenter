<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pembayaran', function (Blueprint $t) {

            /* ── Kode unik 3 digit (awalan jenis + 2 acak) ─────────────── */
            // Disimpan terpisah; nominal asli tetap di jumlah_bayar
            // nominal_transfer = jumlah_bayar + kode_unik (auto-computed accessor)
            if (!Schema::hasColumn('pembayaran', 'kode_unik')) {
                $t->char('kode_unik', 3)->nullable()->after('kode_pembayaran')
                  ->comment('3-digit: digit-1 = jenis (1=pel/2=sert), digit-2~3 = acak 10-99');
            }

            /* ── Perpanjangan waktu bayar ────────────────────────────────── */
            if (!Schema::hasColumn('pembayaran', 'request_perpanjangan_at')) {
                $t->timestamp('request_perpanjangan_at')->nullable()->after('tgl_kadaluarsa')
                  ->comment('Kapan peserta meminta perpanjangan');
            }
            if (!Schema::hasColumn('pembayaran', 'alasan_perpanjangan')) {
                $t->text('alasan_perpanjangan')->nullable()->after('request_perpanjangan_at');
            }
            if (!Schema::hasColumn('pembayaran', 'status_perpanjangan')) {
                // menunggu | disetujui | ditolak | null
                $t->string('status_perpanjangan', 20)->nullable()->after('alasan_perpanjangan');
            }
            if (!Schema::hasColumn('pembayaran', 'catatan_perpanjangan')) {
                $t->text('catatan_perpanjangan')->nullable()->after('status_perpanjangan')
                  ->comment('Catatan admin saat tolak/setujui perpanjangan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pembayaran', function (Blueprint $t) {
            foreach (['kode_unik','request_perpanjangan_at','alasan_perpanjangan',
                      'status_perpanjangan','catatan_perpanjangan'] as $col) {
                if (Schema::hasColumn('pembayaran', $col)) $t->dropColumn($col);
            }
        });
    }
};
