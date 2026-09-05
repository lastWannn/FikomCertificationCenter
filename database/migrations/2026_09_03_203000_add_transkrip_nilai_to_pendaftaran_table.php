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
        if (!Schema::hasColumn('pendaftaran', 'transkrip_nilai')) {
            Schema::table('pendaftaran', function (Blueprint $table) {
                $table->string('transkrip_nilai')->nullable()->after('qr_token');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('pendaftaran', 'transkrip_nilai')) {
            Schema::table('pendaftaran', function (Blueprint $table) {
                $table->dropColumn('transkrip_nilai');
            });
        }
    }
};
