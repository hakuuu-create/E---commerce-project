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

        // ── 1. Verifikasi Signature Key ────────────────────────────────────────
        // Sesuai official docs, signature dibentuk dari:
        // SHA512(order_id + status_code + gross_amount + ServerKey)
        $serverKey         = config('midtrans.server_key');
        $orderId           = $payload['order_id']     ?? '';
        $statusCode        = $payload['status_code']  ?? '';
        $grossAmount       = $payload['gross_amount'] ?? '';
        $incomingSignature = $payload['signature_key'] ?? '';

        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($incomingSignature !== $expectedSignature) {
            Log::warning('[Midtrans] Invalid signature key', ['order_id' => $orderId]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // ── 2. Ambil order_id dari DB ──────────────────────────────────────────
        // order_id di Midtrans kita format: "ORDER-{id}-{timestamp}"
        // Ambil id numerik dengan explode atau regex
        $parts   = explode('-', $orderId); // ['ORDER', '{id}', '{timestamp}']
        $dbOrderId = $parts[1] ?? null;

        $order = Order::find($dbOrderId);

        if (!$order) {
            Log::warning('[Midtrans] Order not found', ['order_id' => $orderId]);
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