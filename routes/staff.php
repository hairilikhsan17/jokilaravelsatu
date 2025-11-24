<?php

use App\Http\Controllers\Staff\DashboardStaffController;
use App\Http\Controllers\Staff\TransaksiStaffController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [DashboardStaffController::class, 'index'])->name('dashboard');
    
    // Transaksi routes
    Route::get('/transaksi', [TransaksiStaffController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/masuk', [TransaksiStaffController::class, 'createMasuk'])->name('transaksi.masuk');
    Route::post('/transaksi/masuk', [TransaksiStaffController::class, 'storeMasuk'])->name('transaksi.masuk.store');
    Route::get('/transaksi/keluar', [TransaksiStaffController::class, 'createKeluar'])->name('transaksi.keluar');
    Route::post('/transaksi/keluar', [TransaksiStaffController::class, 'storeKeluar'])->name('transaksi.keluar.store');
});


