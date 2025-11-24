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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('role');
        });

        // Update enum role untuk menambahkan 'admin'
        \DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('owner', 'admin', 'staff') DEFAULT 'staff'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        // Kembalikan enum role ke semula
        \DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('owner', 'staff') DEFAULT 'staff'");
    }
};
