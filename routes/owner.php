<?php

use App\Http\Controllers\Owner\DashboardOwnerController;
use App\Http\Controllers\Owner\ObatController;
use App\Http\Controllers\Owner\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [DashboardOwnerController::class, 'index'])->name('dashboard');
    
    // Obat routes
    Route::resource('obat', ObatController::class)->except(['show']);
    
    // Transaksi routes
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/masuk', [TransaksiController::class, 'createMasuk'])->name('transaksi.masuk');
    Route::post('/transaksi/masuk', [TransaksiController::class, 'storeMasuk'])->name('transaksi.masuk.store');
    Route::get('/transaksi/keluar', [TransaksiController::class, 'createKeluar'])->name('transaksi.keluar');
    Route::post('/transaksi/keluar', [TransaksiController::class, 'storeKeluar'])->name('transaksi.keluar.store');
});


