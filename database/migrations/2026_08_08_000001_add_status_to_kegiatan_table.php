<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('kegiatan', 'status')) {
            Schema::table('kegiatan', function (Blueprint $table) {
                $table->enum('status', ['draf', 'comingsoon', 'public'])->default('public')->after('jenis_kegiatan');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('kegiatan', 'status')) {
            Schema::table('kegiatan', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
