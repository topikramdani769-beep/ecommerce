<?php
// bootstrap/app.php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);

        // --- TAMBAHKAN KODE INI ---
        $middleware->redirectTo(
            guests: '/login',
            users: '/login', // Memastikan user yang sudah login/register tetap di halaman login (karena nanti kita logout)
        );
        // -------------------------

        $middleware->validateCsrfTokens(except: [
            'midtrans/notification',
            'midtrans/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();