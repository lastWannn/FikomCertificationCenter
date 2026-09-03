<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('pelatihan', 'nama_latar')) {
            Schema::table('pelatihan', function (Blueprint $table) {
                $table->string('nama_latar')->nullable();
                $table->json('sertifikat_layout')->nullable();
            });
        }

        if (!Schema::hasColumn('sertifikasi', 'nama_latar')) {
            Schema::table('sertifikasi', function (Blueprint $table) {
                $table->string('nama_latar')->nullable();
                $table->json('sertifikat_layout')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('pelatihan', 'nama_latar')) {
            Schema::table('pelatihan', function (Blueprint $table) {
                $table->dropColumn(['nama_latar', 'sertifikat_layout']);
            });
        }

        if (Schema::hasColumn('sertifikasi', 'nama_latar')) {
            Schema::table('sertifikasi', function (Blueprint $table) {
                $table->dropColumn(['nama_latar', 'sertifikat_layout']);
            });
        }
    }
};
