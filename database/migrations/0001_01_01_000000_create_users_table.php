<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * FIX MINOR: Migration default Laravel ini sebelumnya membuat tabel `users`
 * tanpa guard, sehingga bisa konflik saat `migrate:fresh` jika project
 * sudah menggunakan tabel terpisah (admins, peserta, instruktur).
 *
 * Perubahan:
 *   - Tabel `users` TIDAK dibuat (tidak digunakan dalam sistem multi-guard FCC)
 *   - Semua pembuatan tabel dibungkus Schema::hasTable() agar idempotent
 *   - Tabel `sessions` dan `password_reset_tokens` tetap dibuat (diperlukan Laravel)
 */
return new class extends Migration
{
    public function up(): void
    {
        // ── sessions — diperlukan saat SESSION_DRIVER=database ──────────
        if (!Schema::hasTable('sessions')) {
            Schema::create('sessions', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->foreignId('user_id')->nullable()->index();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->longText('payload');
                $table->integer('last_activity')->index();
            });
        }

        // ── password_reset_tokens — diperlukan jika fitur reset password aktif ──
        if (!Schema::hasTable('password_reset_tokens')) {
            Schema::create('password_reset_tokens', function (Blueprint $table) {
                $table->string('email')->primary();
                $table->string('token');
                $table->timestamp('created_at')->nullable();
            });
        }

        // CATATAN: Tabel `users` (default Laravel) TIDAK dibuat karena
        // FCC menggunakan tabel terpisah: admins, peserta, instruktur.
        // Model app/Models/User.php dipertahankan untuk kompatibilitas
        // internal Laravel, tapi tidak digunakan dalam alur bisnis FCC.
    }

    public function down(): void
    {
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
