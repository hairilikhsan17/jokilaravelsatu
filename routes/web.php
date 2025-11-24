<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Owner\ObatController as OwnerObatController;
use App\Http\Controllers\Owner\StaffController as OwnerStaffController;
use App\Http\Controllers\Owner\LaporanController as OwnerLaporanController;
use App\Http\Controllers\Owner\RiwayatController as OwnerRiwayatController;
use App\Http\Controllers\Owner\ProfilController as OwnerProfilController;
use App\Http\Controllers\Staff\ObatController as StaffObatController;
use App\Http\Controllers\Staff\LaporanController as StaffLaporanController;
use App\Http\Controllers\Staff\RiwayatController as StaffRiwayatController;
use App\Http\Controllers\Staff\ProfilController as StaffProfilController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/owner', [DashboardController::class, 'owner'])
        ->middleware('role:owner')
        ->name('dashboard.owner');
    
    Route::get('/dashboard/staff', [DashboardController::class, 'staff'])
        ->middleware('role:staff')
        ->name('dashboard.staff');
});

// Owner routes
Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
    // Obat / Alkes routes
    Route::get('/obat', [OwnerObatController::class, 'index'])->name('obat.index');
    Route::post('/obat', [OwnerObatController::class, 'store'])->name('obat.store');
    Route::get('/obat/{id}/edit', [OwnerObatController::class, 'edit'])->name('obat.edit');
    Route::put('/obat/{id}', [OwnerObatController::class, 'update'])->name('obat.update');
    Route::delete('/obat/{id}', [OwnerObatController::class, 'destroy'])->name('obat.destroy');
    
    // Staff Management routes
    Route::get('/staff', [OwnerStaffController::class, 'index'])->name('staff.index');
    Route::post('/staff', [OwnerStaffController::class, 'store'])->name('staff.store');
    Route::get('/staff/{id}/edit', [OwnerStaffController::class, 'edit'])->name('staff.edit');
    Route::put('/staff/{id}', [OwnerStaffController::class, 'update'])->name('staff.update');
    Route::put('/staff/{id}/password', [OwnerStaffController::class, 'updatePassword'])->name('staff.password');
    Route::put('/staff/{id}/toggle-status', [OwnerStaffController::class, 'toggleStatus'])->name('staff.toggle-status');
    Route::delete('/staff/{id}', [OwnerStaffController::class, 'destroy'])->name('staff.destroy');
    
    // Laporan routes
    Route::get('/laporan', [OwnerLaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [OwnerLaporanController::class, 'cetak'])->name('laporan.cetak');
    
    // Riwayat Aktivitas routes
    Route::get('/riwayat', [OwnerRiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/{id}/edit', [OwnerRiwayatController::class, 'edit'])->name('riwayat.edit');
    Route::put('/riwayat/{id}', [OwnerRiwayatController::class, 'update'])->name('riwayat.update');
    Route::delete('/riwayat/{id}', [OwnerRiwayatController::class, 'destroy'])->name('riwayat.destroy');
    
    // Profil routes
    Route::get('/profil', [OwnerProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil', [OwnerProfilController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [OwnerProfilController::class, 'updatePassword'])->name('profil.password');
    Route::delete('/profil/photo', [OwnerProfilController::class, 'deletePhoto'])->name('profil.photo.delete');
});

// Staff routes
Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    // Obat / Alkes routes
    Route::get('/obat', [StaffObatController::class, 'index'])->name('obat.index');
    Route::post('/obat', [StaffObatController::class, 'store'])->name('obat.store');
    Route::get('/obat/{id}/edit', [StaffObatController::class, 'edit'])->name('obat.edit');
    Route::put('/obat/{id}', [StaffObatController::class, 'update'])->name('obat.update');
    Route::delete('/obat/{id}', [StaffObatController::class, 'destroy'])->name('obat.destroy');
    
    // Laporan routes
    Route::get('/laporan', [StaffLaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan', [StaffLaporanController::class, 'store'])->name('laporan.store');
    Route::get('/laporan/{id}/edit', [StaffLaporanController::class, 'edit'])->name('laporan.edit');
    Route::put('/laporan/{id}', [StaffLaporanController::class, 'update'])->name('laporan.update');
    Route::delete('/laporan/{id}', [StaffLaporanController::class, 'destroy'])->name('laporan.destroy');
    Route::get('/laporan/cetak', [StaffLaporanController::class, 'cetak'])->name('laporan.cetak');
    
    // Riwayat Aktivitas routes
    Route::get('/riwayat', [StaffRiwayatController::class, 'index'])->name('riwayat.index');
    
    // Profil routes
    Route::get('/profil', [StaffProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil', [StaffProfilController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [StaffProfilController::class, 'updatePassword'])->name('profil.password');
    Route::delete('/profil/photo', [StaffProfilController::class, 'deletePhoto'])->name('profil.photo.delete');
});
