<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\PeminjamanController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;

// Public routes
Route::post('/register', [AuthController::class, 'register']); // Daftar akun
Route::post('/login', [AuthController::class, 'login']); // Login


Route::middleware('auth:sanctum')->group(function () {
    // Umum (anggota & petugas)
    Route::post('/logout', [AuthController::class, 'logout']); // Logout
    Route::get('/buku', [BukuController::class, 'index']); // Lihat semua buku
    Route::get('/buku/{id}', [BukuController::class, 'show']); // Lihat detail buku
    Route::get('/buku/search/{keyword}', [BukuController::class, 'search']); //search buku
    Route::post('/pinjam/{buku}', [PeminjamanController::class, 'pinjam']); // Pinjam buku
    Route::post('/kembali/{buku}', [PeminjamanController::class, 'kembalikan']); // Kembalikan buku
    Route::get('/peminjaman-user', [PeminjamanController::class, 'peminjamanUser']);


    Route::middleware('petugas')
        ->prefix('petugas')->group(function () {
        Route::post('/buku', [BukuController::class, 'store']);
        Route::put('/buku/{id}', [BukuController::class, 'update']);
        Route::delete('/buku/{id}', [BukuController::class, 'destroy']);

        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{id}', [UserController::class, 'show']);
        Route::post('/users', [UserController::class, 'store']);
        Route::put('/users/{id}', [UserController::class, 'update']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);

        Route::get('/dashboard/stats', [DashboardController::class, 'stats']);

        Route::get('/peminjaman', [PeminjamanController::class, 'index']);

    });
});
