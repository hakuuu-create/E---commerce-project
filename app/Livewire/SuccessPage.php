<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Success - E-commerce project')]
class SuccessPage extends Component
{
    public function render()
    {
        /*
         * Tampilkan order terbaru milik user yang sedang login.
         * Order sudah tersimpan di DB sejak placeOrder() dijalankan,
         * sebelum popup Midtrans dibuka.
         *
         * Catatan: payment_status kemungkinan masih 'pending' di sini —
         * status akan diupdate ke 'paid' saat Midtrans mengirim webhook.
         */
        $latest_order = Order::with('address')
            ->where('user_id', auth('web')->user()->id)
            ->latest()
            ->first();

        return view('livewire.success-page', [
            'order' => $latest_order,
        ]);
    }
}