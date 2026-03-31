<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Address;
use Livewire\Component;
use App\Mail\OrderPlaced;
use Livewire\Attributes\Title;
use App\Helpers\CartManagement;
use Illuminate\Support\Facades\Mail;
use Midtrans\Snap;

#[Title('Checkout')]
class CheckoutPage extends Component
{
    public $first_name;
    public $last_name;
    public $phone;
    public $street_address;
    public $city;
    public $state;
    public $zip_code;
    public $payment_method;

    public function mount()
    {
        $cart_items = CartManagement::getCartItemsFromCookie();
        if (count($cart_items) == 0) {
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
        $grand_total = CartManagement::calculateGrandTotal($cart_items);

        // --- Simpan Order ---
        $order                  = new Order();
        $order->user_id         = auth('web')->user()->id;
        $order->grand_total     = $grand_total;
        $order->payment_method  = $this->payment_method;
        $order->payment_status  = 'pending';
        $order->status          = 'new';
        $order->currency        = 'idr';
        $order->shipping_amount = 0;
        $order->shipping_method = 'none';
        $order->notes           = 'Order placed by ' . auth('web')->user()->name;
        $order->save();

        // --- Simpan Alamat ---
        $address                 = new Address();
        $address->order_id       = $order->id;
        $address->first_name     = $this->first_name;
        $address->last_name      = $this->last_name;
        $address->phone          = $this->phone;
        $address->street_address = $this->street_address;
        $address->city           = $this->city;
        $address->state          = $this->state;
        $address->zip_code       = $this->zip_code;
        $address->save();

        // --- Simpan Order Items ---
        $order->items()->createMany($cart_items);

        // ================================================================
        // MIDTRANS
        // ================================================================
        if ($this->payment_method === 'midtrans') {

            // Format item untuk Midtrans (nama max 50 karakter, harga integer)
            $midtrans_items = array_map(function ($item) {
                return [
                    'id'       => (string) $item['product_id'],
                    'price'    => (int) $item['unit_amount'],
                    'quantity' => (int) $item['quantity'],
                    'name'     => mb_substr($item['name'], 0, 50),
                ];
            }, $cart_items);

            $params = [
                'transaction_details' => [
                    // order_id harus unik di Midtrans, tambahkan timestamp
                    'order_id'     => 'ORDER-' . $order->id . '-' . time(),
                    'gross_amount' => (int) $grand_total,
                ],
                'customer_details' => [
                    'first_name' => $this->first_name,
                    'last_name'  => $this->last_name,
                    'email'      => auth('web')->user()->email,
                    'phone'      => $this->phone,
                ],
                'item_details' => $midtrans_items,
            ];

            try {
                $snapToken = Snap::getSnapToken($params);

                // Simpan snap_token ke order untuk referensi
                $order->update(['snap_token' => $snapToken]);

                // Kosongkan cart
                CartManagement::ClearCartItems();

                // Kirim email notifikasi
                Mail::to(auth('web')->user())->send(new OrderPlaced($order));

                // Dispatch event ke browser → buka Snap popup
                // Livewire 3 gunakan $this->dispatch()
                $this->dispatch('midtrans-snap-open', snapToken: $snapToken);

            } catch (\Exception $e) {
                // Rollback jika gagal generate token
                $order->items()->delete();
                $address->delete();
                $order->delete();

                session()->flash('error', 'Gagal menginisiasi pembayaran Midtrans: ' . $e->getMessage());
            }

        // ================================================================
        // COD
        // ================================================================
        } else {
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