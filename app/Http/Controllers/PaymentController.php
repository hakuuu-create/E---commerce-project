<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Handle HTTP notification / webhook dari Midtrans.
     *
     * Midtrans mengirim POST request JSON ke endpoint ini setiap kali
     * status transaksi berubah (pending → settlement, capture, expire, dsb.)
     *
     * Sesuai official docs:
     *   https://docs.midtrans.com/docs/https-notification-webhooks
     *
     * Cara verifikasi authenticity: bandingkan signature_key dengan:
     *   SHA512(order_id + status_code + gross_amount + server_key)
     */
    public function handleNotification(Request $request)
{
    $payload = $request->all();
    $orderId = $payload['order_id'];

    // 1. Cek apakah ini NOTIFIKASI TEST dari dashboard Midtrans
    if (str_contains($orderId, 'payment_notif_test')) {
        return response()->json(['message' => 'Test notification ignored'], 200);
    }

    // 2. Parsing ID untuk transaksi ASLI (Format: ORDER-123-TIMESTAMP)
    $parts = explode('-', $orderId);
    
    // Pastikan formatnya benar sebelum query ke database
    if (count($parts) < 2 || !is_numeric($parts[1])) {
        Log::error('[Midtrans] Format Order ID tidak dikenali', ['order_id' => $orderId]);
        return response()->json(['message' => 'Invalid order format'], 400);
    }

    $dbOrderId = $parts[1]; // Ini akan mengambil angka '123'
    $order = Order::find($dbOrderId);

    if (!$order) {
        Log::warning('[Midtrans] Order tidak ditemukan di database', ['id_hasil_parsing' => $dbOrderId]);
        return response()->json(['message' => 'Order not found'], 404);
    }

        // ── 3. Update payment_status sesuai transaction_status ─────────────────
        // Referensi status dari official docs:
        //   settlement / capture + fraud_status accept → paid
        //   pending                                    → pending
        //   deny / cancel / expire / failure           → failed
        $transactionStatus = $payload['transaction_status'] ?? '';
        $fraudStatus       = $payload['fraud_status']       ?? 'accept';

        switch ($transactionStatus) {
            case 'capture':
                // Kartu kredit: capture + accept = sukses
                if ($fraudStatus === 'accept') {
                    $order->payment_status = 'paid';
                    $order->status         = 'processing';
                } elseif ($fraudStatus === 'challenge') {
                    $order->payment_status = 'pending';
                }
                break;

            case 'settlement':
                // Transfer / QRIS / e-wallet: settlement = sukses
                $order->payment_status = 'paid';
                $order->status         = 'processing';
                break;

            case 'pending':
                $order->payment_status = 'pending';
                break;

            case 'deny':
            case 'cancel':
            case 'expire':
            case 'failure':
                $order->payment_status = 'failed';
                break;

            default:
                Log::info('[Midtrans] Unhandled transaction_status: ' . $transactionStatus);
                break;
        }

        $order->save();

        // Midtrans menganggap notifikasi berhasil jika kita response HTTP 200
        return response()->json(['message' => 'OK'], 200);
    }
}