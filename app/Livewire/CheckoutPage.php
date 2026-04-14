<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Address;
use Livewire\Component;
use App\Mail\OrderPlaced;
use Livewire\Attributes\Title;
use App\Helpers\CartManagement;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Midtrans\Snap;

#[Title('Checkout')]
class CheckoutPage extends Component
{
    public $first_name, $last_name, $phone, $street_address, $city, $state, $zip_code, $payment_method;

    public function mount()
    {
        $cart_items = CartManagement::getCartItemsFromCookie();
        if (count($cart_items) === 0) {
            return redirect('/products');
        }
    }

    public function placeOrder()
    {
        $this->validate([
            'first_name'     => 'required',
            'last_name'      => 'required',
            'phone'          => 'required',
            'street_address' => 'required',
            'city'           => 'required',
            'state'          => 'required',
            'zip_code'       => 'required',
            'payment_method' => 'required',
        ]);

        $cart_items  = CartManagement::getCartItemsFromCookie();
        
        // 1. Buat Order & Simpan Alamat (Database Transactional)
        $order = new Order();
        $order->user_id         = auth('web')->user()->id;
        $order->payment_method  = $this->payment_method;
        $order->payment_status  = 'pending';
        $order->status          = 'new';
        $order->currency        = 'idr';
        $order->shipping_amount = 0;
        $order->shipping_method = 'none';
        $order->notes           = 'Order placed by ' . auth('web')->user()->name;
        
        // Hitung ulang total untuk memastikan akurasi data
        $calculated_total = 0;
        $item_details = [];

        foreach ($cart_items as $item) {
            $price = (int) $item['unit_amount'];
            $qty   = (int) $item['quantity'];
            
            $item_details[] = [
                'id'       => (string) $item['product_id'],
                'price'    => $price,
                'quantity' => $qty,
                'name'     => mb_substr($item['name'], 0, 50),
            ];
            $calculated_total += ($price * $qty);
        }

        $order->grand_total = $calculated_total;
        $order->save();

        // Simpan Alamat
        $address = new Address();
        $address->order_id       = $order->id;
        $address->first_name     = $this->first_name;
        $address->last_name      = $this->last_name;
        $address->phone          = $this->phone;
        $address->street_address = $this->street_address;
        $address->city           = $this->city;
        $address->state          = $this->state;
        $address->zip_code       = $this->zip_code;
        $address->save();

        $order->items()->createMany($cart_items);

        // 2. Proses Pembayaran Midtrans
        if ($this->payment_method === 'midtrans') {
            $params = [
                'transaction_details' => [
                    'order_id'     => 'ORDER-' . $order->id . '-' . time(),
                    'gross_amount' => (int) $calculated_total,
                ],
                'customer_details' => [
                    'first_name' => $this->first_name,
                    'last_name'  => $this->last_name,
                    'email'      => auth('web')->user()->email,
                    'phone'      => $this->phone,
                ],
                'item_details' => $item_details,
            ];

            try {
                $snapToken = Snap::getSnapToken($params);
                $order->update(['snap_token' => $snapToken]);

                CartManagement::ClearCartItems();
                Mail::to(auth('web')->user())->send(new OrderPlaced($order));

                $this->dispatch('open-snap', snapToken: $snapToken);

            } catch (\Exception $e) {
                // Rollback jika gagal dapet token
                $order->items()->delete();
                $address->delete();
                $order->delete();

                Log::error('Midtrans Error: ' . $e->getMessage());
                session()->flash('error', 'Gagal inisiasi pembayaran. Silakan coba lagi.');
            }

        } else {
            // COD Logic
            CartManagement::ClearCartItems();
            Mail::to(auth('web')->user())->send(new OrderPlaced($order));
            return redirect()->route('success');
        }
    }

    public function render()
    {
        $cart_items  = CartManagement::getCartItemsFromCookie();
        $grand_total = CartManagement::calculateGrandTotal($cart_items);

        return view('livewire.checkout-page', [
            'cart_items'  => $cart_items,
            'grand_total' => $grand_total,
        ]);
    }
}