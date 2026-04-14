<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <h1 class="text-4xl font-bold text-slate-500">Order Details</h1>
  
    @if(session('error'))
    <div class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
        {{ session('error') }}
    </div>
    @endif

    <!-- Grid -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mt-5">
      <!-- Card Customer -->
      <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-800">
        <div class="p-4 md:p-5 flex gap-x-4">
          <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
            <svg class="flex-shrink-0 size-5 text-gray-600 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
              <circle cx="9" cy="7" r="4" />
              <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
              <path d="M16 3.13a4 4 0 0 1 0 7.75" />
            </svg>
          </div>
          <div class="grow">
            <div class="flex items-center gap-x-2">
              <p class="text-xs uppercase tracking-wide text-gray-500">Customer</p>
            </div>
            <div class="mt-1 flex items-center gap-x-2">
              <div>{{ $address->full_name }}</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Card Order Date -->
      <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-800">
        <div class="p-4 md:p-5 flex gap-x-4">
          <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
            <svg class="flex-shrink-0 size-5 text-gray-600 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M5 22h14" />
              <path d="M5 2h14" />
              <path d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22" />
              <path d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2" />
            </svg>
          </div>
          <div class="grow">
            <div class="flex items-center gap-x-2">
              <p class="text-xs uppercase tracking-wide text-gray-500">Order Date</p>
            </div>
            <div class="mt-1 flex items-center gap-x-2">
              <h3 class="text-xl font-medium text-gray-800 dark:text-gray-200">
                {{ $order_items[0]->created_at->format('d-n-Y')}}
              </h3>
            </div>
          </div>
        </div>
      </div>

      <!-- Card Order Status -->
      <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-800">
        <div class="p-4 md:p-5 flex gap-x-4">
          <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
            <svg class="flex-shrink-0 size-5 text-gray-600 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 11V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h6" />
              <path d="m12 12 4 10 1.7-4.3L22 16Z" />
            </svg>
          </div>
          <div class="grow">
            <div class="flex items-center gap-x-2">
              <p class="text-xs uppercase tracking-wide text-gray-500">Order Status</p>
            </div>
            <div class="mt-1 flex items-center gap-x-2">
              @php
                $status = '';
                if($order->status=='new'){
                    $status = '<span class="bg-blue-500 py-1 px-3 rounded text-white shadow">New</span>';
                }
                if($order->status=='processing'){
                    $status = '<span class="bg-yellow-500 py-1 px-3 rounded text-white shadow">Processing</span>';
                }
                if($order->status=='shipped'){
                    $status = '<span class="bg-green-500 py-1 px-3 rounded text-white shadow">Shipped</span>';
                }
                if($order->status=='delivered'){
                    $status = '<span class="bg-green-700 py-1 px-3 rounded text-white shadow">Delivered</span>';
                }
                if($order->status=='cancelled'){
                    $status = '<span class="bg-red-500 py-1 px-3 rounded text-white shadow">Cancelled</span>';
                }
              @endphp
              {!! $status !!}
            </div>
          </div>
        </div>
      </div>

      <!-- Card Payment Status -->
      <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-slate-900 dark:border-gray-800">
        <div class="p-4 md:p-5 flex gap-x-4">
          <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
            <svg class="flex-shrink-0 size-5 text-gray-600 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M5 12s2.545-5 7-5c4.454 0 7 5 7 5s-2.546 5-7 5c-4.455 0-7-5-7-5z" />
              <path d="M12 13a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
              <path d="M21 17v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2" />
              <path d="M21 7V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2" />
            </svg>
          </div>
          <div class="grow">
            <div class="flex items-center gap-x-2">
              <p class="text-xs uppercase tracking-wide text-gray-500">Payment Status</p>
            </div>
            <div class="mt-1 flex items-center gap-x-2">
              @php
                $payment_status = '';
                if($order->payment_status == 'pending'){
                    $payment_status = '<span class="bg-blue-500 py-1 px-3 rounded text-white shadow">Pending</span>';
                }
                if($order->payment_status == 'paid'){
                    $payment_status = '<span class="bg-green-500 py-1 px-3 rounded text-white shadow">Paid</span>';
                }
                if($order->payment_status == 'failed'){
                    $payment_status = '<span class="bg-red-600 py-1 px-3 rounded text-white shadow">Failed</span>';
                }
              @endphp
              {!! $payment_status !!}
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- ===== TOMBOL BAYAR SEKARANG (hanya muncul jika midtrans + pending) ===== --}}
    @if($order->payment_method === 'midtrans' && $order->payment_status === 'pending')
    <div class="mt-6 p-5 bg-yellow-50 border border-yellow-200 rounded-xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-yellow-800">Pembayaran Belum Selesai</p>
                <p class="text-sm text-yellow-600">Order ini menunggu pembayaran via Midtrans. Klik tombol di samping untuk melanjutkan.</p>
            </div>
        </div>
        <button
            wire:click="bayarSekarang"
            wire:loading.attr="disabled"
            class="shrink-0 inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-3 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
            <span wire:loading.remove wire:target="bayarSekarang">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
                </svg>
                Bayar Sekarang
            </span>
            <span wire:loading wire:target="bayarSekarang" class="inline-flex items-center gap-2">
                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                Memuat...
            </span>
        </button>
    </div>
    @endif
    {{-- ===== END TOMBOL BAYAR ===== --}}

    <div class="flex flex-col md:flex-row gap-4 mt-4">
      <div class="md:w-3/4">
        <div class="bg-white overflow-x-auto rounded-lg shadow-md p-6 mb-4">
          <table class="w-full">
            <thead>
              <tr>
                <th class="text-left font-semibold">Product</th>
                <th class="text-left font-semibold">Price</th>
                <th class="text-left font-semibold">Quantity</th>
                <th class="text-left font-semibold">Total</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($order_items as $item )
              <tr wire:key="{{ $item->id }}">
                <td class="py-4">
                  <div class="flex items-center">
                    <img class="h-16 w-16 mr-4" src="{{ url('storage',$item->product->images[0]) }}" alt="{{ $item->product->name }}">
                    <span class="font-semibold">{{ $item->product->name }}</span>
                  </div>
                </td>
                <td class="py-4">{{ Number::currency($item->unit_amount,'idr') }}</td>
                <td class="py-4">
                  <span class="text-center w-8">{{ $item->quantity }}</span>
                </td>
                <td class="py-4">{{ Number::currency($item->total_amount,'idr') }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="bg-white overflow-x-auto rounded-lg shadow-md p-6 mb-4">
          <h1 class="font-3xl font-bold text-slate-500 mb-3">Shipping Address</h1>
          <div class="flex justify-between items-center">
            <div>
              <p>{{ $address->street_address }},{{ $address->city }}, {{ $address->state }}, {{ $address->zip_code }}</p>
            </div>
            <div>
              <p class="font-semibold">Phone:</p>
              <p>{{ $address->phone }}</p>
            </div>
          </div>
        </div>
      </div>

      <div class="md:w-1/4">
        <div class="bg-white rounded-lg shadow-md p-6">
          <h2 class="text-lg font-semibold mb-4">Summary</h2>
          <div class="flex justify-between mb-2">
            <span>Subtotal</span>
            <span>{{ Number::currency($item->order->grand_total,'idr') }}</span>
          </div>
          <div class="flex justify-between mb-2">
            <span>Taxes</span>
            <span>{{ Number::currency(0,'idr') }}</span>
          </div>
          <div class="flex justify-between mb-2">
            <span>Shipping</span>
            <span>{{ Number::currency(0,'idr') }}</span>
          </div>
          <hr class="my-2">
          <div class="flex justify-between mb-2">
            <span class="font-semibold">Grand Total</span>
            <span class="font-semibold">{{ Number::currency($item->order->grand_total,'idr') }}</span>
          </div>
        </div>

        {{-- Info payment method --}}
        <div class="bg-white rounded-lg shadow-md p-6 mt-4">
          <h2 class="text-sm font-semibold text-gray-500 uppercase mb-2">Payment Method</h2>
          <p class="font-semibold text-gray-800">
            {{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'QRIS / Transfer Bank (Midtrans)' }}
          </p>
        </div>
      </div>
    </div>
</div>

{{-- ===== MIDTRANS SNAP.JS (dimuat hanya jika order midtrans pending) ===== --}}
@if($order->payment_method === 'midtrans' && $order->payment_status === 'pending')
<script
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}">
</script>

<script>
    document.addEventListener('livewire:init', function () {
        Livewire.on('open-snap', function (data) {
            const snapToken = data.snapToken ?? data[0]?.snapToken ?? null;

            if (!snapToken) {
                console.error('[Midtrans] Snap token tidak ditemukan:', data);
                return;
            }

            window.snap.pay(snapToken, {
                onSuccess: function (result) {
                    console.log('[Midtrans] onSuccess:', result);
                    // Reload halaman agar status diperbarui
                    window.location.reload();
                },
                onPending: function (result) {
                    console.log('[Midtrans] onPending:', result);
                    alert('Pembayaran sedang diproses. Status akan diperbarui otomatis.');
                    window.location.reload();
                },
                onError: function (result) {
                    console.error('[Midtrans] onError:', result);
                    alert('Pembayaran gagal. Silakan coba lagi.');
                },
                onClose: function () {
                    console.log('[Midtrans] Popup ditutup.');
                }
            });
        });
    });
</script>
@endif