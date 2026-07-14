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
        Schema::create('instruktur_detail', function (Blueprint $table) {
            $table->foreignId('id_user')->primary()->constrained('users')->cascadeOnDelete();
            $table->string('no_identitas')->unique();
            $table->text('alamat')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('no_hp');
            $table->string('keahlian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instruktur_detail');
    }
};
