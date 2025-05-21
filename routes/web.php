<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard'); // kalau sudah login, masuk dashboard
    }
    return redirect('/login'); // kalau belum login, masuk login
});

Route::get('/{any}', function () {
    return view('home'); // atau 'app', tergantung view-mu
})->where('any', '.*');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
