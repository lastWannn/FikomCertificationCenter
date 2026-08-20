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
        Schema::table('testimoni', function (Blueprint $table) {
            $table->foreignId('peserta_id')->nullable()->after('id')->constrained('peserta')->onDelete('cascade');
            $table->string('status')->default('dipublikasikan')->after('foto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('testimoni', function (Blueprint $table) {
            $table->dropForeign(['peserta_id']);
            $table->dropColumn(['peserta_id', 'status']);
        });
    }
};
