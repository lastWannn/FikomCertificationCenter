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
        Schema::table('pelatihan', function (Blueprint $table) {
            $table->dropForeign(['instruktur_id']);
            $table->dropColumn('instruktur_id');
        });

        Schema::dropIfExists('instruktur');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('instruktur', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('nama', 100);
            $table->string('nip', 50)->nullable()->unique();
            $table->string('instansi', 100)->nullable();
            $table->string('jabatan', 100)->nullable();
            $table->string('telepon', 20)->nullable();
            $table->string('foto')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('pelatihan', function (Blueprint $table) {
            $table->foreignId('instruktur_id')->nullable()->constrained('instruktur')->restrictOnDelete()->cascadeOnUpdate();
        });
    }
};
