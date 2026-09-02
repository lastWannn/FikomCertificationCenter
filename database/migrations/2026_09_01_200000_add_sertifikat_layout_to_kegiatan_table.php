<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('kegiatan', 'sertifikat_layout')) {
            Schema::table('kegiatan', function (Blueprint $table) {
                $table->json('sertifikat_layout')->nullable()->after('nama_latar');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('kegiatan', 'sertifikat_layout')) {
            Schema::table('kegiatan', function (Blueprint $table) {
                $table->dropColumn('sertifikat_layout');
            });
        }
    }
};
