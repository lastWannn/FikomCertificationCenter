<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * FCC memakai tabel terpisah per role (admins, peserta, instruktur),
 * bukan tabel `users` bawaan default Laravel. Migration ini membersihkan
 * tabel `users` yang sempat terbuat sebelum sistem multi-guard dipakai.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Anak dulu (FK ke users.id), baru induknya
        Schema::dropIfExists('peserta_detail');
        Schema::dropIfExists('instruktur_detail');
        Schema::dropIfExists('users');
    }

    public function down(): void
    {
        // Tidak direkonstruksi — FCC tidak lagi menggunakan tabel `users`.
    }
};
