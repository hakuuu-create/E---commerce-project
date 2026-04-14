<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Address;
use Livewire\Component;
use App\Models\OrderItem;
use Livewire\Attributes\Title;
use Midtrans\Snap;

#[Title('Order Detail Page')]
class MyOrderDetailPage extends Component{

    public $order_id;

    public function mount($order_id){
        $this->order_id = $order_id;
    }

    /**
     * Generate ulang snap token jika belum ada / expired,
     * lalu dispatch event ke JS untuk membuka popup Midtrans.
     */
    public function bayarSekarang(): void
    {
        $order = Order::with(['items.product', 'address', 'user'])
            ->where('id', $this->order_id)
            ->where('user_id', auth('web')->id())
            ->firstOrFail();

        // Jika snap_token masih ada, langsung pakai
        if ($order->snap_token) {
            $this->dispatch('open-snap', snapToken: $order->snap_token);
            return;
        }

        // Buat snap_token baru
        try {
            $item_details = $order->items->map(fn($item) => [
                'id'       => (string) $item->product_id,
                'price'    => (int) $item->unit_amount,
                'quantity' => (int) $item->quantity,
                'name'     => mb_substr($item->product->name, 0, 50),
            ])->toArray();

            $params = [
                'transaction_details' => [
                    'order_id'     => 'ORDER-' . $order->id . '-' . time(),
                    'gross_amount' => (int) $order->grand_total,
                ],
                'customer_details' => [
                    'first_name' => $order->address->first_name ?? $order->user->name,
                    'last_name'  => $order->address->last_name ?? '',
                    'email'      => $order->user->email,
                    'phone'      => $order->address->phone ?? '',
                ],
                'item_details' => $item_details,
            ];

            $snapToken = Snap::getSnapToken($params);
            $order->update(['snap_token' => $snapToken]);

            $this->dispatch('open-snap', snapToken: $snapToken);

        } catch (\Exception $e) {
            session()->flash('error', 'Gagal membuka pembayaran: ' . $e->getMessage());
        }
    }

    public function render(){
        $order_items = OrderItem::with('product')->where('order_id',$this->order_id)->get();
        $address = Address::where('order_id',$this->order_id)->first();
        $order = Order::where('id',$this->order_id)->first();
        return view('livewire.my-order-detail-page',[
            'order_items' => $order_items,
            'address' => $address,
            'order' => $order
        ]);
    }
}