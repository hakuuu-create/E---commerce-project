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
        $grand_total = CartManagement::calculateGrandTotal($cart_items);

        // ── 1. Simpan Order ──────────────────────────────────────────────────
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

        // ── 2. Simpan Alamat ─────────────────────────────────────────────────
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

        // ── 3. Simpan Order Items ─────────────────────────────────────────────
        $order->items()->createMany($cart_items);

        // ── 4. Proses Pembayaran ──────────────────────────────────────────────
        if ($this->payment_method === 'midtrans') {

            /*
             * Format item_details untuk Midtrans.
             * Rules dari docs:
             *   - id     : string
             *   - price  : integer (bukan desimal)
             *   - name   : string, max 50 karakter
             * Jumlah seluruh (price * quantity) HARUS sama dengan gross_amount.
             */
            $item_details = array_map(function ($item) {
                return [
                    'id'       => (string) $item['product_id'],
                    'price'    => (int) $item['unit_amount'],
                    'quantity' => (int) $item['quantity'],
                    'name'     => mb_substr($item['name'], 0, 50),
                ];
            }, $cart_items);

            /*
             * order_id di Midtrans HARUS unik untuk setiap transaksi.
             * Kalau pakai $order->id saja dan pembayaran gagal lalu coba lagi,
             * Midtrans akan reject karena order_id sudah pernah dipakai.
             * Solusi: tambahkan timestamp supaya selalu unik.
             */
            $params = [
                'transaction_details' => [
                    'order_id'     => 'ORDER-' . $order->id . '-' . time(),
                    'gross_amount' => (int) $grand_total,
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
                /*
                 * Snap::getSnapToken() melakukan POST ke Midtrans API:
                 * POST https://app.sandbox.midtrans.com/snap/v1/transactions
                 * Mengembalikan array ['token' => '...', 'redirect_url' => '...']
                 * atau langsung string token — tergantung versi library.
                 */
                $snapToken = Snap::getSnapToken($params);

                // Simpan snap_token ke DB agar bisa dipakai ulang jika perlu
                $order->update(['snap_token' => $snapToken]);

                // Kosongkan cart SETELAH token berhasil didapat
                CartManagement::ClearCartItems();

                // Kirim email notifikasi pesanan
                Mail::to(auth('web')->user())->send(new OrderPlaced($order));

                /*
                 * Kirim event ke frontend (Livewire 3).
                 * Di blade kita tangkap dengan:
                 *   Livewire.on('open-snap', (data) => { snap.pay(data.snapToken) })
                 *
                 * PENTING: Livewire 3 mengirim named argument, jadi di JS
                 * data akan berupa object: { snapToken: '...' }
                 */
                $this->dispatch('open-snap', snapToken: $snapToken);

            } catch (\Exception $e) {
                /*
                 * Jika gagal generate token (misal server key salah, gross_amount
                 * tidak cocok, dsb.) → rollback data order agar tidak ada ghost order.
                 */
                $order->items()->delete();
                $address->delete();
                $order->delete();

                session()->flash('error', 'Gagal inisiasi pembayaran: ' . $e->getMessage());
            }

        } else {
            // ── COD ───────────────────────────────────────────────────────────
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