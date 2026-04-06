<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // Tambahkan ini

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 1. Paksa HTTPS jika diakses via ngrok
        if (str_contains(request()->getHttpHost(), 'ngrok-free.app')) {
            URL::forceScheme('https');
        }

        // 2. Konfigurasi Midtrans
        \Midtrans\Config::$serverKey    = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = (bool) config('midtrans.is_production');
        \Midtrans\Config::$isSanitized  = (bool) config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds        = (bool) config('midtrans.is_3ds');
    }
}