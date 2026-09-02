<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sertifikat', function (Blueprint $table) {
            $table->json('ttd_snapshot')->nullable()->after('gambar_latar');
        });

        Schema::table('pembayaran', function (Blueprint $table) {
            $table->json('ttd_snapshot')->nullable()->after('no_kwitansi');
        });

        // Backfill snapshot untuk sertifikat dan pembayaran yang sudah ada
        $aktif = \App\Models\TandaTangan::getAktif();
        $snapshotSertifikat = [
            'dekan_nama'    => $aktif->dekan_nama,
            'dekan_jabatan' => $aktif->dekan_jabatan,
            'dekan_nip'     => $aktif->dekan_nip,
            'dekan_ttd'     => $aktif->dekan_ttd,
            'ketua_nama'    => $aktif->ketua_nama,
            'ketua_jabatan' => $aktif->ketua_jabatan,
            'ketua_nip'     => $aktif->ketua_nip,
            'ketua_ttd'     => $aktif->ketua_ttd,
        ];

        $snapshotInvoice = [
            'bendahara_nama'    => $aktif->bendahara_nama,
            'bendahara_jabatan' => $aktif->bendahara_jabatan,
            'bendahara_nip'     => $aktif->bendahara_nip,
            'bendahara_ttd'     => $aktif->bendahara_ttd,
        ];

        \DB::table('sertifikat')->whereNull('ttd_snapshot')->update([
            'ttd_snapshot' => json_encode($snapshotSertifikat)
        ]);

        \DB::table('pembayaran')->whereNull('ttd_snapshot')->update([
            'ttd_snapshot' => json_encode($snapshotInvoice)
        ]);
    }

    public function down(): void
    {
        Schema::table('sertifikat', function (Blueprint $table) {
            $table->dropColumn('ttd_snapshot');
        });

        Schema::table('pembayaran', function (Blueprint $table) {
            $table->dropColumn('ttd_snapshot');
        });
    }
};
