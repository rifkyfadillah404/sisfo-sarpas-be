<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Api\BarangApiController;
use App\Http\Controllers\Api\KategoriBarangApiController;
use App\Http\Controllers\Api\PeminjamanController;
use App\Http\Controllers\Api\PengembalianController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});


Route::prefix('user')->group(function () {
    Route::get('kategori-barang', [KategoriBarangApiController::class, 'index']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/barang', [BarangApiController::class, 'index']);
    Route::post('/peminjaman', [PeminjamanController::class, 'store']);
    Route::get('/peminjaman/user', [PeminjamanController::class, 'index']);
    Route::post('/pengembalian', [PengembalianController::class, 'store']);
    Route::get('/pengembalian/user', [PengembalianController::class, 'index']);
});


