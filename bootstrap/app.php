

<?php
 
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
        /*
         * Exclude rute webhook Midtrans dari CSRF protection.
         *
         * Midtrans mengirim POST request dari server mereka, sehingga tidak
         * membawa CSRF token. Jika tidak dikecualikan, semua notifikasi akan
         * ditolak dengan HTTP 419 (Token Mismatch).
         *
         * Sesuai official docs:
         *   https://docs.midtrans.com/docs/https-notification-webhooks
         * 
         */
        $middleware->trustProxies(at: '*'); 

        $middleware->validateCsrfTokens(except: [
        '/payment/notification', 
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
 
