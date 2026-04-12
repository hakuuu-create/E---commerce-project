<div class="min-h-screen bg-gray-50">
    

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Breadcrumb --}}
        <div class="flex items-center text-sm text-gray-500 mb-6">
            <a href="/" class="hover:text-blue-600 transition">Beranda</a>
            <svg class="w-4 h-4 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-700 font-medium">Produk</span>
        </div>

        <div class="flex flex-wrap -mx-3">
            {{-- Sidebar Filter --}}
            <div class="w-full lg:w-1/4 px-3">
                <div class="sticky top-24 space-y-5">
                    {{-- Filter Kategori --}}
                    <div class="bg-white rounded-xl shadow-sm border border-blue-100 overflow-hidden">
                        <div class="p-4 border-b border-blue-100 bg-blue-50/30">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                    </svg>
                                    Kategori
                                </h3>
                                @if(count($selected_categories) > 0)
                                    <button wire:click="resetCategories" class="text-xs text-blue-600 hover:text-blue-800">Reset</button>
                                @endif
                            </div>
                        </div>
                        <div class="p-4 max-h-80 overflow-y-auto">
                            @foreach ($categories as $category)
                            <label wire:key="{{ $category->id }}" class="flex items-center gap-3 py-2 hover:bg-blue-50/50 px-2 -mx-2 rounded-lg transition cursor-pointer">
                                <input type="checkbox" wire:model.live="selected_categories" value="{{ $category->id }}" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-gray-700 text-sm">{{ $category->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Filter Brand --}}
                    <div class="bg-white rounded-xl shadow-sm border border-blue-100 overflow-hidden">
                        <div class="p-4 border-b border-blue-100 bg-blue-50/30">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    Brand
                                </h3>
                                @if(count($selected_brands) > 0)
                                    <button wire:click="resetBrands" class="text-xs text-blue-600 hover:text-blue-800">Reset</button>
                                @endif
                            </div>
                        </div>
                        <div class="p-4 max-h-64 overflow-y-auto">
                            @foreach ($brands as $brand)
                            <label wire:key="{{ $brand->id }}" class="flex items-center gap-3 py-2 hover:bg-blue-50/50 px-2 -mx-2 rounded-lg transition cursor-pointer">
                                <input type="checkbox" wire:model.live="selected_brands" value="{{ $brand->id }}" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-gray-700 text-sm">{{ $brand->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Filter Status Produk --}}
                    <div class="bg-white rounded-xl shadow-sm border border-blue-100 overflow-hidden">
                        <div class="p-4 border-b border-blue-100 bg-blue-50/30">
                            <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Status Produk
                            </h3>
                        </div>
                        <div class="p-4 space-y-2">
                            <label class="flex items-center gap-3 py-2 hover:bg-blue-50/50 px-2 -mx-2 rounded-lg transition cursor-pointer">
                                <input type="checkbox" wire:model.live="featured" value="1" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-gray-700 text-sm">Featured Product</span>
                            </label>
                            <label class="flex items-center gap-3 py-2 hover:bg-blue-50/50 px-2 -mx-2 rounded-lg transition cursor-pointer">
                                <input type="checkbox" wire:model.live="on_sale" value="1" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-gray-700 text-sm">On Sale</span>
                            </label>
                        </div>
                    </div>

                    {{-- Filter Harga --}}
                    <div class="bg-white rounded-xl shadow-sm border border-blue-100 overflow-hidden">
                        <div class="p-4 border-b border-blue-100 bg-blue-50/30">
                            <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Harga
                            </h3>
                        </div>
                        <div class="p-4">
                            <div class="mb-4">
                                <span class="text-2xl font-bold text-blue-600">{{ Number::currency($price_range, 'IDR') }}</span>
                            </div>
                            <input type="range" wire:model.live="price_range" class="w-full h-2 bg-blue-100 rounded-lg appearance-none cursor-pointer accent-blue-600" max="50000000" min="1000" step="1000">
                            <div class="flex justify-between mt-2 text-xs text-gray-500">
                                <span>{{ Number::currency(1000, 'IDR') }}</span>
                                <span>{{ Number::currency(50000000, 'IDR') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main Content: Produk --}}
            <div class="w-full lg:w-3/4 px-3 mt-6 lg:mt-0">
                {{-- Header & Sorting --}}
                <div class="bg-white rounded-xl shadow-sm border border-blue-100 p-4 mb-6 flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="text-gray-600 text-sm">
                            Menampilkan <span class="font-semibold text-gray-800">{{ $products->total() }}</span> produk
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-500">Urutkan:</span>
                        <select wire:model.live="sort" class="border border-blue-200 rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="latest">Terbaru</option>
                            <option value="price">Termurah</option>
                        </select>
                    </div>
                </div>

                {{-- Grid Produk --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($products as $product)
                    <div wire:key="{{ $product->id }}" class="group bg-white rounded-xl shadow-sm border border-blue-100 overflow-hidden hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        {{-- Gambar Produk --}}
                        <a href="/products/{{ $product->slug }}" class="block relative overflow-hidden bg-gray-100 h-48">
                            <img src="{{ url('storage', $product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @if($product->discount_percent ?? false)
                                <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-md">Diskon {{ $product->discount_percent }}%</span>
                            @endif
                        </a>

                        {{-- Informasi Produk --}}
                        <div class="p-4">
                            <a href="/products/{{ $product->slug }}" class="block">
                                <h3 class="font-semibold text-gray-800 text-base mb-1 line-clamp-2 hover:text-blue-600 transition">{{ $product->name }}</h3>
                            </a>
                            
                            
                            {{-- Harga --}}
                            <div class="mt-2">
                                <span class="text-xl font-bold text-blue-600">{{ Number::currency($product->price, 'IDR') }}</span>
                                @if($product->old_price ?? false)
                                    <span class="text-sm text-gray-400 line-through ml-2">{{ Number::currency($product->old_price, 'IDR') }}</span>
                                @endif
                            </div>

                            {{-- Tombol Add to Cart --}}
                            <button wire:click.prevent="addToCart({{ $product->id }})" class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-lg transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6M17 13l1.5 6M9 21h6M12 21v-6"></path>
                                </svg>
                                <span wire:loading.remove wire:target="addToCart({{ $product->id }})">Tambah ke Keranjang</span>
                                <span wire:loading wire:target="addToCart({{ $product->id }})">Menambahkan...</span>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8 flex justify-center">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Notifikasi dengan Alpine --}}
    <div 
        x-data="{ show: false, message: '' }" 
        x-on:cartItemAdded.window="
            message = $event.detail.message;
            show = true;
            setTimeout(() => show = false, 3000);
        "
        class="fixed bottom-5 right-5 z-50"
    >
        <div 
            x-show="show" 
            x-transition.duration.300ms
            class="bg-green-500 text-white px-5 py-3 rounded-lg shadow-lg flex items-center gap-3"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span x-text="message"></span>
        </div>
    </div>
</div>