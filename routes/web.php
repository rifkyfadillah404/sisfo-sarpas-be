<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriBarangController;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PengembalianController;

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    // Route Laporan
    Route::get('laporan/stok', [LaporanController::class, 'stok'])->name('laporan.stok');
    Route::get('laporan/peminjaman', [LaporanController::class, 'peminjaman'])->name('laporan.peminjaman');
    Route::get('laporan/pengembalian', [LaporanController::class, 'pengembalian'])->name('laporan.pengembalian');

    // Route Kategori Barang
    Route::get('/kategori-barang', [KategoriBarangController::class, 'index'])->name('kategori.index');
    Route::get('/kategori-barang/create', [KategoriBarangController::class, 'create'])->name('kategori.create');
    Route::post('/kategori-barang', [KategoriBarangController::class, 'store'])->name('kategori.store');
    Route::get('/kategori-barang/{id}/edit', [KategoriBarangController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori-barang/{id}', [KategoriBarangController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori-barang/{id}', [KategoriBarangController::class, 'destroy'])->name('kategori.destroy');

    // Route Barang
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');

    // Route Peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('admin.peminjaman.index');
    Route::post('/peminjaman/{id}/approve', [PeminjamanController::class, 'approve'])->name('admin.peminjaman.approve');
    Route::post('/peminjaman/{id}/reject', [PeminjamanController::class, 'reject'])->name('admin.peminjaman.reject');
    Route::post('/admin/peminjaman/{id}/return', [PeminjamanController::class, 'return'])->name('admin.peminjaman.return');
    Route::get('/admin/pengembalian', [PengembalianController::class, 'index'])->name('admin.pengembalian.index');

    Route::get('pengembalian', [PengembalianController::class, 'index'])->name('admin.pengembalian.index');
    Route::post('pengembalian/{id}/approve', [PengembalianController::class, 'approve'])->name('admin.pengembalian.approve');
    Route::post('pengembalian/{id}/reject', [PengembalianController::class, 'reject'])->name('admin.pengembalian.reject');
    Route::get('pengembalian/{id}/mark-damaged', [PengembalianController::class, 'markDamaged'])->name('admin.pengembalian.markDamaged');
    Route::post('pengembalian/{id}/update-damaged', [PengembalianController::class, 'updateDamaged'])->name('admin.pengembalian.updateDamaged');

    // Route Laporan Peminjaman (berbeda dari peminjaman data)
    Route::get('laporan/peminjaman-data', [LaporanController::class, 'peminjaman'])->name('laporan.peminjaman-data');
});
