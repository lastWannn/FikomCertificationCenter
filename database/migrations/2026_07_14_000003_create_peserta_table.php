<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('peserta', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->text('alamat')->nullable();
            $table->string('email', 150)->unique();
            $table->enum('kelamin', ['L', 'P']);
            $table->string('instansi', 200)->nullable();
            $table->string('no_hp', 20);
            $table->string('foto')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('peserta'); }
};
