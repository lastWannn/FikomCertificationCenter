<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasColumn('kontak', 'nama')) {
            Schema::table('kontak', function (Blueprint $table) {
                $table->string('nama', 150)->nullable()->after('id')->comment('Nama Kontak / Penanggung Jawab');
            });
        }
    }

    public function down(): void {
        if (Schema::hasColumn('kontak', 'nama')) {
            Schema::table('kontak', function (Blueprint $table) {
                $table->dropColumn('nama');
            });
        }
    }
};
