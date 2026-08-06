<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::table('admins', function (Blueprint $table) {
            $table->enum('role', ['super_admin', 'admin'])->default('admin')->after('email');
        });

        // Set the first existing admin as super_admin
        DB::table('admins')->where('id', 1)->update(['role' => 'super_admin']);
    }

    public function down(): void {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
