<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('peserta', function (Blueprint $table) {
            if (!Schema::hasColumn('peserta', 'pekerjaan')) {
                $table->string('pekerjaan', 100)->nullable()->after('instansi');
            }
        });
    }

    public function down(): void {
        Schema::table('peserta', function (Blueprint $table) {
            if (Schema::hasColumn('peserta', 'pekerjaan')) {
                $table->dropColumn('pekerjaan');
            }
        });
    }
};
