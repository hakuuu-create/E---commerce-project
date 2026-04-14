<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">

    {{-- ── PAGE HEADER ── --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">My Orders</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Lacak dan kelola semua pesanan Anda</p>
    </div>

    {{-- ── EMPTY STATE ── --}}
    @if ($orders->isEmpty())
        <div class="flex flex-col items-center justify-center bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 py-24 px-6">
            <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-5">
                <svg class="w-10 h-10 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300 mb-1">Belum ada pesanan</h3>
            <p class="text-sm text-gray-400 mb-6">Yuk mulai belanja dan temukan produk favoritmu!</p>
            <a href="/products"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                </svg>
                Mulai Belanja
            </a>
        </div>

    @else
        <div class="space-y-4">
            @foreach ($orders as $order)

            {{-- ── ORDER CARD ── --}}
            <div wire:key="{{ $order->id }}"
                 class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden">

                {{-- Card Header --}}
                <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 bg-gray-50 dark:bg-slate-900/50 border-b border-gray-100 dark:border-gray-700">

                    {{-- Order ID + Tanggal --}}
                    <div class="flex items-center gap-4">
                        <div>
                            <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Order</span>
                            <p class="text-sm font-bold text-gray-800 dark:text-white">#{{ $order->id }}</p>
                        </div>
                        <div class="w-px h-8 bg-gray-200 dark:bg-gray-700"></div>
                        <div>
                            <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Tanggal</span>
                            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                {{ $order->created_at->translatedFormat('d M Y') }}
                            </p>
                        </div>
                        <div class="w-px h-8 bg-gray-200 dark:bg-gray-700"></div>
                        <div>
                            <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">{{ $order->items->count() }} item</span>
                            <p class="text-sm font-bold text-blue-600 dark:text-blue-400">
                                {{ Number::currency($order->grand_total, 'IDR') }}
                            </p>
                        </div>
                    </div>

                    {{-- Badges --}}
                    <div class="flex items-center gap-2 flex-wrap">

                        {{-- Order Status --}}
                        @php
                            $statusConfig = [
                                'new'        => ['label' => 'Baru',       'bg' => 'bg-blue-50 dark:bg-blue-900/30',   'text' => 'text-blue-700 dark:text-blue-400',   'dot' => 'bg-blue-500'],
                                'processing' => ['label' => 'Diproses',   'bg' => 'bg-amber-50 dark:bg-amber-900/30', 'text' => 'text-amber-700 dark:text-amber-400', 'dot' => 'bg-amber-500'],
                                'shipped'    => ['label' => 'Dikirim',    'bg' => 'bg-indigo-50 dark:bg-indigo-900/30','text'=> 'text-indigo-700 dark:text-indigo-400','dot'=> 'bg-indigo-500'],
                                'delivered'  => ['label' => 'Terkirim',   'bg' => 'bg-emerald-50 dark:bg-emerald-900/30','text'=>'text-emerald-700 dark:text-emerald-400','dot'=>'bg-emerald-500'],
                                'cancelled'  => ['label' => 'Dibatalkan', 'bg' => 'bg-red-50 dark:bg-red-900/30',    'text' => 'text-red-700 dark:text-red-400',     'dot' => 'bg-red-500'],
                            ];
                            $sc = $statusConfig[$order->status] ?? $statusConfig['new'];

                            $payConfig = [
                                'pending' => ['label' => 'Menunggu', 'bg' => 'bg-yellow-50 dark:bg-yellow-900/30', 'text' => 'text-yellow-700 dark:text-yellow-400'],
                                'paid'    => ['label' => 'Lunas',    'bg' => 'bg-green-50 dark:bg-green-900/30',   'text' => 'text-green-700 dark:text-green-400'],
                                'failed'  => ['label' => 'Gagal',    'bg' => 'bg-red-50 dark:bg-red-900/30',       'text' => 'text-red-700 dark:text-red-400'],
                            ];
                            $pc = $payConfig[$order->payment_status] ?? $payConfig['pending'];
                        @endphp

                        <span class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1.5 rounded-full {{ $sc['bg'] }} {{ $sc['text'] }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $sc['dot'] }}"></span>
                            {{ $sc['label'] }}
                        </span>

                        <span class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1.5 rounded-full {{ $pc['bg'] }} {{ $pc['text'] }}">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            {{ $pc['label'] }}
                        </span>
                    </div>
                </div>

                {{-- Card Body: Item Previews --}}
                <div class="px-5 py-4">
                    <div class="flex items-center gap-3">

                        {{-- Gambar produk (max 4, sisanya counter) --}}
                        <div class="flex items-center -space-x-2">
                            @foreach ($order->items->take(4) as $idx => $item)
                                @php $isLast = $idx === 3 && $order->items->count() > 4; @endphp
                                <div class="relative w-12 h-12 rounded-xl border-2 border-white dark:border-slate-800
                                            overflow-hidden bg-gray-100 shadow-sm flex-shrink-0
                                            {{ $idx > 0 ? 'ring-2 ring-white dark:ring-slate-800' : '' }}">
                                    @if($isLast)
                                        {{-- Counter overlay --}}
                                        <img src="{{ url('storage', $item->product->images[0]) }}"
                                             alt="" class="w-full h-full object-cover opacity-30">
                                        <div class="absolute inset-0 flex items-center justify-center bg-gray-900/60">
                                            <span class="text-white text-xs font-black">+{{ $order->items->count() - 3 }}</span>
                                        </div>
                                    @else
                                        <img src="{{ url('storage', $item->product->images[0]) }}"
                                             alt="{{ $item->product->name }}"
                                             class="w-full h-full object-cover">
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        {{-- Daftar nama produk --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap gap-x-2 gap-y-0.5">
                                @foreach ($order->items->take(3) as $item)
                                    <span class="text-sm text-gray-700 dark:text-gray-300 font-medium truncate max-w-[180px]">
                                        {{ $item->product->name }}
                                        <span class="text-gray-400 font-normal">×{{ $item->quantity }}</span>
                                    </span>
                                    @if (!$loop->last)
                                        <span class="text-gray-300 dark:text-gray-600 hidden sm:inline">·</span>
                                    @endif
                                @endforeach
                                @if ($order->items->count() > 3)
                                    <span class="text-xs text-gray-400 dark:text-gray-500 font-medium self-center">
                                        & {{ $order->items->count() - 3 }} produk lainnya
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                                {{ $order->items->sum('quantity') }} item
                                · via {{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'QRIS / Transfer' }}
                            </p>
                        </div>

                        {{-- Tombol Detail --}}
                        <a href="/my-orders/{{ $order->id }}"
                           class="flex-shrink-0 inline-flex items-center gap-1.5 text-sm font-semibold
                                  text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300
                                  bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/40
                                  px-4 py-2 rounded-xl transition-colors duration-150">
                            Detail
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Progress bar status (opsional visual) --}}
                @if (!in_array($order->status, ['cancelled']))
                    @php
                        $steps     = ['new', 'processing', 'shipped', 'delivered'];
                        $curIdx    = array_search($order->status, $steps);
                        $curIdx    = $curIdx === false ? 0 : $curIdx;
                        $pct       = round(($curIdx / (count($steps) - 1)) * 100);
                    @endphp
                    <div class="px-5 pb-4">
                        <div class="flex items-center justify-between mb-1.5">
                            @foreach(['Baru', 'Diproses', 'Dikirim', 'Terkirim'] as $si => $slabel)
                                <span class="text-xs font-semibold {{ $si <= $curIdx ? 'text-blue-600 dark:text-blue-400' : 'text-gray-300 dark:text-gray-600' }}">
                                    {{ $slabel }}
                                </span>
                            @endforeach
                        </div>
                        <div class="w-full h-1.5 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500
                                        {{ $order->status === 'delivered' ? 'bg-emerald-500' : 'bg-blue-500' }}"
                                 style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @else
                    <div class="px-5 pb-3">
                        <div class="flex items-center gap-2 text-xs font-semibold text-red-500 dark:text-red-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Pesanan ini telah dibatalkan
                        </div>
                    </div>
                @endif
            </div>

            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $orders->links() }}
        </div>

    @endif

</div>