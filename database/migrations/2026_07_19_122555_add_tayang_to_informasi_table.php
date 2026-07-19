<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('informasi', function (Blueprint $table) {
            $table->dateTime('tayang_mulai')->nullable()->after('jenis')
                  ->comment('Tanggal mulai tayang; null = langsung aktif');
            $table->dateTime('tayang_selesai')->nullable()->after('tayang_mulai')
                  ->comment('Tanggal selesai tayang; null = tidak ada batas waktu');
        });
    }

    public function down(): void
    {
        Schema::table('informasi', function (Blueprint $table) {
            $table->dropColumn(['tayang_mulai', 'tayang_selesai']);
        });
    }
};
