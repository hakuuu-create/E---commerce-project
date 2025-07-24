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
use Midtrans\Config;

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
    public $snapToken; // Properti untuk menyimpan Snap Token Midtrans

    public function mount()
    {
        $cart_items = CartManagement::getCartItemsFromCookie();
        if (count($cart_items) == 0) {
            return redirect('/products');
        }

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function placeOrder()
    {
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'street_address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip_code' => 'required',
            'payment_method' => 'required',
        ]);

        $cart_items = CartManagement::getCartItemsFromCookie();

        // Format item untuk Midtrans
        $midtrans_items = array_map(function ($item) {
            return [
                'id' => $item['product_id'],
                'price' => $item['unit_amount'],
                'quantity' => $item['quantity'],
                'name' => $item['name'],
            ];
        }, $cart_items);

        // Simpan pesanan
        $order = new Order();
        $order->user_id = auth('web')->user()->id;
        $order->grand_total = CartManagement::calculateGrandTotal($cart_items);
        $order->payment_method = $this->payment_method;
        $order->payment_status = 'pending';
        $order->status = 'new';
        $order->currency = 'idr';
        $order->shipping_amount = '0';
        $order->shipping_method = 'none';
        $order->notes = 'Order placed by ' . auth('web')->user()->name;
        $order->save();

        // Simpan alamat
        $address = new Address();
        $address->first_name = $this->first_name;
        $address->last_name = $this->last_name;
        $address->phone = $this->phone;
        $address->street_address = $this->street_address;
        $address->city = $this->city;
        $address->state = $this->state;
        $address->zip_code = $this->zip_code;
        $address->order_id = $order->id;
        $address->save();

        // Simpan item pesanan
        $order->items()->createMany($cart_items);

        $redirect_url = '';

        if ($this->payment_method == 'midtrans') {
            // Buat transaksi Midtrans
            $transaction_details = [
                'order_id' => $order->id . '-' . uniqid(),
                'gross_amount' => $order->grand_total,
            ];

            $customer_details = [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => auth('web')->user()->email,
                'phone' => $this->phone,
            ];

            $transaction_data = [
                'transaction_details' => $transaction_details,
                'customer_details' => $customer_details,
                'item_details' => $midtrans_items,
            ];

            try {
                $this->snapToken = Snap::getSnapToken($transaction_data);
                $order->update(['snap_token' => $this->snapToken]);
            } catch (\Exception $e) {
                session()->flash('error', 'Failed to initiate Midtrans payment: ' . $e->getMessage());
                return redirect()->back();
            }

            // Tidak langsung redirect, biarkan Livewire render Snap popup
            $redirect_url = null;
        } else {
            $redirect_url = route('success');
        }

        // Kosongkan keranjang
        CartManagement::clearCartItems();

        // Kirim email notifikasi
        Mail::to(auth('web')->user())->send(new OrderPlaced($order));

        if ($redirect_url) {
            return redirect($redirect_url);
        }

        // Render ulang halaman untuk menampilkan Snap popup
        return null;
    }

    public function render()
    {
        $cart_items = CartManagement::getCartItemsFromCookie();
        $grand_total = CartManagement::calculateGrandTotal($cart_items);
        return view('livewire.checkout-page', [
            'cart_items' => $cart_items,
            'grand_total' => $grand_total,
            'snapToken' => $this->snapToken,
        ]);
    }
}