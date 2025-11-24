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
        Schema::create('obat_alkes', function (Blueprint $table) {
            $table->id();                             // ID unik
            $table->string('nama');                   // Nama obat / alkes
            $table->string('kategori');               // Kategori: Obat / Alkes
            $table->integer('stok')->default(0);      // Jumlah stok
            $table->date('kadaluarsa')->nullable();   // Tanggal kadaluarsa (boleh kosong)
            $table->string('supplier')->nullable();   // Nama supplier / pemasok
            $table->string('satuan')->nullable();     // Satuan (tablet, botol, pcs, box, dsb)
            $table->string('lokasi')->nullable();     // Lokasi penyimpanan (rak / gudang)
            $table->text('keterangan')->nullable();   // Catatan tambahan
            $table->timestamps();                     // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obat_alkes');
    }
};
