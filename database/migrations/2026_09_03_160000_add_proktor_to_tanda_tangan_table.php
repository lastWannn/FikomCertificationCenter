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
        Schema::table('tanda_tangan', function (Blueprint $table) {
            $table->string('proktor_nama')->nullable()->after('bendahara_ttd');
            $table->string('proktor_jabatan')->nullable()->after('proktor_nama');
            $table->string('proktor_nip')->nullable()->after('proktor_jabatan');
            $table->string('proktor_ttd')->nullable()->after('proktor_nip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tanda_tangan', function (Blueprint $table) {
            $table->dropColumn(['proktor_nama', 'proktor_jabatan', 'proktor_nip', 'proktor_ttd']);
        });
    }
};
