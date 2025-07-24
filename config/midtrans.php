<?php

return [
    'merchant_id' => env('MIDTRANS_MERCHANT_ID', ''),
    'client_key' => env('midtrans.client_key', ''),
    'server_key' => env('midtrans.server_key', ''),
    'is_production' => env('midtrans.is_production', false),
    'is_sanitized' => env('midtrans.is_sanitized', true),
    'is_3ds' => env('midtrans.is_3ds', true),
];