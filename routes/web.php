<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriBarangController;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\PengembalianController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\LaporanController;


Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    Route::get('laporan/stok', [DashboardController::class, 'laporanStok'])->name('laporan.stok');
    Route::get('laporan/peminjaman', [DashboardController::class, 'laporanPeminjaman'])->name('laporan.peminjaman');
    Route::get('laporan/pengembalian', [DashboardController::class, 'laporanPengembalian'])->name('laporan.pengembalian');

    Route::get('/kategori-barang', [KategoriBarangController::class, 'index'])->name('kategori.index');
    Route::get('/kategori-barang/create', [KategoriBarangController::class, 'create'])->name('kategori.create');
    Route::post('/kategori-barang', [KategoriBarangController::class, 'store'])->name('kategori.store');
    Route::get('/kategori-barang/{id}/edit', [KategoriBarangController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori-barang/{id}', [KategoriBarangController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori-barang/{id}', [KategoriBarangController::class, 'destroy'])->name('kategori.destroy');

    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');

    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/{id}/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
    Route::put('/peminjaman/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
    Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');

    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::get('/pengembalian/create', [PengembalianController::class, 'create'])->name('pengembalian.create');
    Route::post('/pengembalian', [PengembalianController::class, 'store'])->name('pengembalian.store');
    Route::get('/pengembalian/{id}/edit', [PengembalianController::class, 'edit'])->name('pengembalian.edit');
    Route::put('/pengembalian/{id}', [PengembalianController::class, 'update'])->name('pengembalian.update');
    Route::delete('/pengembalian/{id}', [PengembalianController::class, 'destroy'])->name('pengembalian.destroy');

    Route::get('/stok', [LaporanController::class, 'stok'])->name('stok');
    Route::get('/peminjaman', [LaporanController::class, 'peminjaman'])->name('peminjaman');
    Route::get('/pengembalian', [LaporanController::class, 'pengembalian'])->name('pengembalian');
});
