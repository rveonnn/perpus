<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\PeminjamanController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register', [AuthController::class, 'register']); // Daftar akun
Route::post('/login', [AuthController::class, 'login']); // Login

// Routes yang butuh login (middleware auth:sanctum)
Route::middleware('auth:sanctum')->group(function () {
    // Umum (anggota & petugas)
    Route::post('/logout', [AuthController::class, 'logout']); // Logout
    Route::get('/buku', [BukuController::class, 'index']); // Lihat semua buku
    Route::get('/buku/{id}', [BukuController::class, 'show']); // Lihat detail buku
    Route::get('/buku/search/{keyword}', [BukuController::class, 'search']); //search buku
    Route::post('/pinjam/{buku}', [PeminjamanController::class, 'pinjam']); // Pinjam buku
    Route::post('/kembali/{buku}', [PeminjamanController::class, 'kembalikan']); // Kembalikan buku
    Route::get('/peminjaman-user', [PeminjamanController::class, 'peminjamanUser']);
    // Khusus Petugas (middleware 'petugas')
    Route::middleware('petugas')->group(function () {

    });
});
