<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function getSnapToken(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        $transaction_details = [
            'order_id' => $order->id . '-' . uniqid(),
            'gross_amount' => $order->grand_total,
        ];

        $customer_details = [
            'first_name' => $order->addresses->first_name ?? 'Guest',
            'email' => $order->user->email ?? 'guest@example.com',
            'phone' => $order->addresses->phone ?? '',
        ];

        $items = $order->order_items->map(function ($item) {
            return [
                'id' => $item->product_id,
                'price' => $item->unit_amount,
                'quantity' => $item->quantity,
                'name' => $item->product->name,
            ];
        })->toArray();

        $transaction_data = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $items,
        ];

        try {
            $snapToken = Snap::getSnapToken($transaction_data);
            $order->update(['snap_token' => $snapToken]);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function handleNotification(Request $request)
    {
        $notification = json_decode($request->getContent(), true);

        // Validasi signature key untuk keamanan
        $signatureKey = hash('sha512', $notification['order_id'] . $notification['status_code'] . $notification['gross_amount'] . config('midtrans.server_key'));

        if ($signatureKey !== $notification['signature_key']) {
            return response()->json(['error' => 'Invalid signature'], 403);
        }

        $orderId = explode('-', $notification['order_id'])[0];
        $order = Order::findOrFail($orderId);

        switch ($notification['transaction_status']) {
            case 'capture':
            case 'settlement':
                $order->update(['payment_status' => 'paid']);
                break;
            case 'pending':
                $order->update(['payment_status' => 'pending']);
                break;
            case 'deny':
            case 'expire':
            case 'cancel':
                $order->update(['payment_status' => 'failed']);
                break;
        }

        return response()->json(['status' => 'success']);
    }
}