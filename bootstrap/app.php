<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Middleware\HandleCors;

// Middleware
use App\Http\Middleware\isPetugas;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->appendToGroup('petugas', [isPetugas::class]);
        $middleware->append([
            HandleCors::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();

$app->booted(function () use ($app) {
    $schedule = $app->make(Schedule::class);

    $schedule->call(function () {
        \App\Models\Peminjaman::where('status', 'unavailable')
            ->where('tanggal_pengembalian', '<', now())
            ->where(function($query) {
                $query->whereNull('tanggal_dikembalikan')
                      ->orWhere('status', '!=', 'terlambat');
            })
            ->update([
                'status' => 'terlambat',
            ]);
    })->dailyAt('00:00');
});



return $app;
