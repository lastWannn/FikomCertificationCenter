<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('instruktur', function (Blueprint $table) {
            $table->id();
            $table->string('no_identitas', 50);
            $table->string('nama', 150);
            $table->text('alamat')->nullable();
            $table->string('email', 150)->unique();
            $table->enum('kelamin', ['L', 'P']);
            $table->string('no_hp', 20);
            $table->string('keahlian');
            $table->string('password');
            $table->string('foto')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('instruktur'); }
};
