<?php

namespace App\Livewire\Midtrans;

use Midtrans\Config;
use Midtrans\Snap as MidtransSnap;

class Snap
{
    public static function getSnapToken(array $params)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Ambil token Snap
        return MidtransSnap::getSnapToken($params);
    }
}
