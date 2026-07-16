<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ── kegiatan ─────────────────────────────────────────────
        Schema::table('kegiatan', function (Blueprint $t) {
            // qr_token: unik per event, untuk QR presensi
            if (!Schema::hasColumn('kegiatan', 'qr_token')) {
                $t->string('qr_token', 64)->unique()->nullable()->after('jenis_kegiatan');
            }
            // nama_latar: sudah ada di migration awal → skip jika duplikat
            if (!Schema::hasColumn('kegiatan', 'nama_latar')) {
                $t->string('nama_latar')->nullable()->after('qr_token');
            }
        });

        // ── peserta ───────────────────────────────────────────────
        Schema::table('peserta', function (Blueprint $t) {
            if (!Schema::hasColumn('peserta', 'status_akun')) {
                $t->enum('status_akun', ['aktif', 'nonaktif', 'ditangguhkan'])
                  ->default('aktif')->after('created_at');
            }
            if (!Schema::hasColumn('peserta', 'email_verified_at')) {
                $t->timestamp('email_verified_at')->nullable()->after('email');
            }
            if (!Schema::hasColumn('peserta', 'remember_token')) {
                $t->rememberToken()->after('password');
            }
        });

        // ── pendaftaran ───────────────────────────────────────────
        Schema::table('pendaftaran', function (Blueprint $t) {
            if (!Schema::hasColumn('pendaftaran', 'qr_token')) {
                $t->string('qr_token', 64)->unique()->nullable()->after('status_kehadiran');
            }
        });
    }

    public function down(): void
    {
        Schema::table('kegiatan', function (Blueprint $t) {
            if (Schema::hasColumn('kegiatan', 'qr_token'))  $t->dropColumn('qr_token');
            // nama_latar TIDAK di-drop karena bisa saja berasal dari migration awal
        });
        Schema::table('peserta', function (Blueprint $t) {
            if (Schema::hasColumn('peserta', 'status_akun'))       $t->dropColumn('status_akun');
            if (Schema::hasColumn('peserta', 'email_verified_at')) $t->dropColumn('email_verified_at');
            if (Schema::hasColumn('peserta', 'remember_token'))    $t->dropColumn('remember_token');
        });
        Schema::table('pendaftaran', function (Blueprint $t) {
            if (Schema::hasColumn('pendaftaran', 'qr_token')) $t->dropColumn('qr_token');
        });
    }
};
