<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('jadwal_pelatihan', function (Blueprint $table) {
            $table->dropColumn(['nama_jenis_biaya', 'nominal_biaya']);
            $table->json('biaya_setup')->nullable()->after('nama_kegiatan');
        });

        Schema::table('jadwal_sertifikasi', function (Blueprint $table) {
            $table->dropColumn(['nama_jenis_biaya', 'nominal_biaya']);
            $table->json('biaya_setup')->nullable()->after('nama_kegiatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_pelatihan', function (Blueprint $table) {
            $table->dropColumn('biaya_setup');
            $table->string('nama_jenis_biaya', 100)->nullable()->after('nama_kegiatan');
            $table->decimal('nominal_biaya', 12, 0)->nullable()->after('nama_jenis_biaya');
        });

        Schema::table('jadwal_sertifikasi', function (Blueprint $table) {
            $table->dropColumn('biaya_setup');
            $table->string('nama_jenis_biaya', 100)->nullable()->after('nama_kegiatan');
            $table->decimal('nominal_biaya', 12, 0)->nullable()->after('nama_jenis_biaya');
        });
    }
};
