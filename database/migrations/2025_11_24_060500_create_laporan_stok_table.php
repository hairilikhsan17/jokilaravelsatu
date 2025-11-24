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
        Schema::create('laporan_stok', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_obat')->constrained('obat_alkes')->onDelete('cascade');
            $table->foreignId('id_staff')->constrained('users')->onDelete('cascade');
            $table->integer('jumlah');
            $table->date('tanggal');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_stok');
    }
};
