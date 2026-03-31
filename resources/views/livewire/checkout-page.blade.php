<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Checkout</h1>

    {{-- Flash error --}}
    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent='placeOrder'>
        <div class="grid grid-cols-12 gap-4">

            {{-- ======================== LEFT: Form ======================== --}}
            <div class="md:col-span-12 lg:col-span-8 col-span-12">
                <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">

                    {{-- Shipping Address --}}
                    <h2 class="text-xl font-bold underline text-gray-700 dark:text-white mb-4">
                        Shipping Address
                    </h2>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 dark:text-white mb-1" for="first_name">First Name</label>
                            <input wire:model='first_name'
                                class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none
                                       @error('first_name') border-red-500 @enderror"
                                id="first_name" type="text">
                            @error('first_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-white mb-1" for="last_name">Last Name</label>
                            <input wire:model='last_name'
                                class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none
                                       @error('last_name') border-red-500 @enderror"
                                id="last_name" type="text">
                            @error('last_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-gray-700 dark:text-white mb-1" for="phone">Phone</label>
                        <input wire:model='phone'
                            class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none
                                   @error('phone') border-red-500 @enderror"
                            id="phone" type="text">
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block text-gray-700 dark:text-white mb-1" for="address">Street Address</label>
                        <input wire:model='street_address'
                            class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none
                                   @error('street_address') border-red-500 @enderror"
                            id="address" type="text">
                        @error('street_address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block text-gray-700 dark:text-white mb-1" for="city">City</label>
                        <input wire:model='city'
                            class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none
                                   @error('city') border-red-500 @enderror"
                            id="city" type="text">
                        @error('city')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-gray-700 dark:text-white mb-1" for="state">State / Province</label>
                            <input wire:model='state'
                                class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none
                                       @error('state') border-red-500 @enderror"
                                id="state" type="text">
                            @error('state')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-white mb-1" for="zip">ZIP Code</label>
                            <input wire:model='zip_code'
                                class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none
                                       @error('zip_code') border-red-500 @enderror"
                                id="zip" type="text">
                            @error('zip_code')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Payment Method --}}
                    <h2 class="text-lg font-semibold mt-8 mb-4">Select Payment Method</h2>

                    <ul class="grid w-full gap-6 md:grid-cols-2">
                        {{-- COD --}}
                        <li>
                            <input wire:model='payment_method'
                                class="hidden peer"
                                id="pay-cod" type="radio" value="cod" required />
                            <label for="pay-cod"
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border
                                       border-gray-200 rounded-lg cursor-pointer
                                       peer-checked:border-blue-600 peer-checked:text-blue-600
                                       hover:text-gray-600 hover:bg-gray-100
                                       dark:text-gray-400 dark:bg-gray-800 dark:border-gray-700
                                       dark:hover:bg-gray-700 dark:peer-checked:text-blue-500
                                       dark:hover:text-gray-300">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">Cash on Delivery</div>
                                    <div class="text-sm text-gray-500">Bayar saat barang tiba</div>
                                </div>
                                <svg class="w-5 h-5 ms-3 rtl:rotate-180" fill="none" viewBox="0 0 14 10">
                                    <path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </label>
                        </li>

                        {{-- Midtrans --}}
                        <li>
                            <input wire:model='payment_method'
                                class="hidden peer"
                                id="pay-midtrans" type="radio" value="midtrans" />
                            <label for="pay-midtrans"
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border
                                       border-gray-200 rounded-lg cursor-pointer
                                       peer-checked:border-blue-600 peer-checked:text-blue-600
                                       hover:text-gray-600 hover:bg-gray-100
                                       dark:text-gray-400 dark:bg-gray-800 dark:border-gray-700
                                       dark:hover:bg-gray-700 dark:peer-checked:text-blue-500
                                       dark:hover:text-gray-300">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">QRIS / Transfer Bank</div>
                                    <div class="text-sm text-gray-500">via Midtrans (Sandbox)</div>
                                </div>
                                <svg class="w-5 h-5 ms-3 rtl:rotate-180" fill="none" viewBox="0 0 14 10">
                                    <path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </label>
                        </li>
                    </ul>

                    @error('payment_method')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror

                </div>
            </div>

            {{-- ======================== RIGHT: Summary ======================== --}}
            <div class="md:col-span-12 lg:col-span-4 col-span-12">

                {{-- Order Summary --}}
                <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-4">ORDER SUMMARY</div>
                    <div class="flex justify-between mb-2">
                        <span>Subtotal</span>
                        <span class="font-semibold">{{ Number::currency($grand_total, 'IDR') }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Taxes</span>
                        <span>{{ Number::currency(0, 'IDR') }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Shipping</span>
                        <span>{{ Number::currency(0, 'IDR') }}</span>
                    </div>
                    <hr class="my-3">
                    <div class="flex justify-between font-bold text-lg">
                        <span>Grand Total</span>
                        <span>{{ Number::currency($grand_total, 'IDR') }}</span>
                    </div>
                </div>

                {{-- Place Order Button --}}
                <button type="submit"
                    wire:loading.attr="disabled"
                    class="bg-green-500 mt-4 w-full p-3 rounded-lg text-lg text-white font-semibold
                           hover:bg-green-600 disabled:opacity-50 disabled:cursor-not-allowed
                           transition-colors duration-200">
                    <span wire:loading.remove wire:target="placeOrder">Place Order</span>
                    <span wire:loading wire:target="placeOrder">
                        <svg class="animate-spin inline-block w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        Memproses...
                    </span>
                </button>

                {{-- Basket Summary --}}
                <div class="bg-white mt-4 rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-3">BASKET SUMMARY</div>
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($cart_items as $ci)
                            <li class="py-3 sm:py-4" wire:key='{{ $ci['product_id'] }}'>
                                <div class="flex items-center gap-3">
                                    <img alt="{{ $ci['name'] }}"
                                        class="w-12 h-12 rounded-lg object-cover"
                                        src="{{ url('storage', $ci['images']) }}">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                            {{ $ci['name'] }}
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Qty: {{ $ci['quantity'] }}
                                        </p>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ Number::currency($ci['total_amount'], 'IDR') }}
                                    </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </form>
</div>

{{-- ============================================================ --}}
{{-- MIDTRANS SNAP SCRIPT                                         --}}
{{-- Sandbox: app.sandbox.midtrans.com                           --}}
{{-- Production: app.midtrans.com                                --}}
{{-- ============================================================ --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    /**
     * Livewire 3 menggunakan Livewire.on() untuk mendengarkan event dari server.
     * Event 'midtrans-snap-open' di-dispatch dari CheckoutPage::placeOrder()
     * setelah snap token berhasil didapat dari API Midtrans.
     */
    document.addEventListener('livewire:init', function () {

        Livewire.on('midtrans-snap-open', function (data) {
            // data berupa object { snapToken: '...' } dari Livewire 3
            const token = data.snapToken ?? (Array.isArray(data) ? data[0]?.snapToken : null);

            if (!token) {
                console.error('[Midtrans] snap token tidak ditemukan:', data);
                return;
            }

            snap.pay(token, {
                onSuccess: function (result) {
                    console.log('[Midtrans] Pembayaran berhasil:', result);
                    window.location.href = '{{ route('success') }}';
                },
                onPending: function (result) {
                    console.log('[Midtrans] Pembayaran pending:', result);
                    // Pending = user sudah dapat instruksi bayar (transfer, QRIS, dll)
                    window.location.href = '{{ route('success') }}';
                },
                onError: function (result) {
                    console.error('[Midtrans] Pembayaran gagal:', result);
                    alert('Pembayaran gagal: ' + result.status_message);
                    window.location.href = '{{ route('cancel') }}';
                },
                onClose: function () {
                    // User menutup popup → tidak redirect, biarkan user mencoba lagi
                    console.log('[Midtrans] Popup ditutup oleh user');
                }
            });
        });

    });
</script>