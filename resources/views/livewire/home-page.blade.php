<div>
    {{-- ===================== HERO SECTION ===================== --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 min-h-screen flex items-center">
        {{-- Decorative circles --}}
        <div class="absolute top-0 left-0 w-96 h-96 bg-blue-600 opacity-10 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-indigo-500 opacity-10 rounded-full translate-x-1/4 translate-y-1/4"></div>

        <div class="w-full max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-24 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                {{-- Left --}}
                <div>
                    <span class="inline-flex items-center gap-2 bg-blue-500/20 text-blue-300 text-sm font-medium px-4 py-1.5 rounded-full mb-6 border border-blue-500/30">
                        <span class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></span>
                        New arrivals every week
                    </span>
                    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold text-white leading-[1.1] mb-6">
                        Shop Smart,<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">
                            Live Better
                        </span>
                    </h1>
                    <p class="text-lg text-slate-300 leading-relaxed mb-10 max-w-lg">
                        Discover thousands of premium products at unbeatable prices. From electronics to fashion — everything you need, delivered fast.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="/products"
                           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white font-semibold px-8 py-4 rounded-xl transition-all duration-200 shadow-lg shadow-blue-900/40">
                            Shop Now
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                        <a href="/categories"
                           class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white font-semibold px-8 py-4 rounded-xl border border-white/20 transition-all duration-200">
                            View Categories
                        </a>
                    </div>

                    {{-- Stats --}}
                    <div class="grid grid-cols-3 gap-6 mt-14 pt-10 border-t border-white/10">
                        <div>
                            <p class="text-3xl font-bold text-white">10K+</p>
                            <p class="text-sm text-slate-400 mt-1">Products</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-white">50K+</p>
                            <p class="text-sm text-slate-400 mt-1">Happy Customers</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-white">4.9★</p>
                            <p class="text-sm text-slate-400 mt-1">Average Rating</p>
                        </div>
                    </div>
                </div>

                {{-- Right --}}
                <div class="relative hidden lg:block">
                    <div class="relative bg-white/5 backdrop-blur-sm rounded-3xl p-2 border border-white/10">
                        <img
                            src="https://static.vecteezy.com/system/resources/previews/011/993/278/non_2x/3d-render-online-shopping-bag-using-credit-card-or-cash-for-future-use-credit-card-money-financial-security-on-mobile-3d-application-3d-shop-purchase-basket-retail-store-on-e-commerce-free-png.png"
                            alt="Online Shopping" class="w-full rounded-2xl">
                    </div>
                    {{-- Floating card --}}
                    <div class="absolute -bottom-4 -left-6 bg-white rounded-2xl shadow-xl p-4 flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Order placed</p>
                            <p class="text-sm font-semibold text-gray-800">Delivered in 2hrs!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== FEATURES STRIP ===================== --}}
    <section class="bg-white border-b border-gray-100">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1 12a2 2 0 002 2h8a2 2 0 002-2l1-12"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Free Shipping</p>
                        <p class="text-xs text-gray-500">On orders over 500K</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Easy Returns</p>
                        <p class="text-xs text-gray-500">30-day return policy</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Secure Payment</p>
                        <p class="text-xs text-gray-500">100% protected</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">24/7 Support</p>
                        <p class="text-xs text-gray-500">Always here to help</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== BRANDS SECTION ===================== --}}
    <section class="py-20 bg-gray-50">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <p class="text-sm font-semibold text-blue-600 uppercase tracking-widest mb-3">Trusted Partners</p>
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Popular Brands</h2>
                <p class="text-gray-500 max-w-xl mx-auto">Explore top brands trusted by millions of shoppers worldwide.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($brands as $brand)
                <a href="/products?selected_brands[0]={{ $brand->id }}"
                   wire:key="{{ $brand->id }}"
                   class="group bg-white rounded-2xl overflow-hidden border border-gray-100 hover:border-blue-200 hover:shadow-lg transition-all duration-300">
                    <div class="aspect-[4/3] overflow-hidden bg-gray-50">
                        <img src="{{ url('storage', $brand->image) }}"
                             alt="{{ $brand->name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="px-5 py-4 flex items-center justify-between">
                        <h3 class="font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">
                            {{ $brand->name }}
                        </h3>
                        <span class="w-8 h-8 bg-gray-100 group-hover:bg-blue-600 rounded-full flex items-center justify-center transition-all duration-200">
                            <svg class="w-4 h-4 text-gray-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                            </svg>
                        </span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===================== CATEGORIES SECTION ===================== --}}
    <section class="py-20 bg-white">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-14">
                <div>
                    <p class="text-sm font-semibold text-blue-600 uppercase tracking-widest mb-3">Browse by Category</p>
                    <h2 class="text-4xl font-bold text-gray-900">Shop by Category</h2>
                </div>
                <a href="/categories" class="hidden sm:inline-flex items-center gap-2 text-blue-600 font-medium hover:text-blue-700 transition-colors">
                    View all
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($categories as $category)
                <a href="/products?selected_categories[0]={{ $category->id }}"
                   wire:key="{{ $category->id }}"
                   class="group relative rounded-2xl overflow-hidden aspect-square cursor-pointer">
                    <img src="{{ url('storage', $category->image) }}"
                         alt="{{ $category->name }}"
                         class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/30 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4">
                        <h3 class="text-white font-semibold text-base group-hover:text-blue-300 transition-colors">
                            {{ $category->name }}
                        </h3>
                        <span class="text-white/70 text-xs mt-0.5 inline-flex items-center gap-1">
                            Shop now
                            <svg class="w-3 h-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </span>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="mt-8 sm:hidden text-center">
                <a href="/categories" class="inline-flex items-center gap-2 text-blue-600 font-medium">
                    View all categories
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- ===================== BANNER CTA ===================== --}}
    <section class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-[85rem] mx-auto">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl overflow-hidden">
                <div class="grid lg:grid-cols-2 gap-0">
                    <div class="p-10 lg:p-14 flex flex-col justify-center">
                        <span class="text-blue-200 text-sm font-semibold uppercase tracking-widest mb-4">Limited Time Offer</span>
                        <h2 class="text-4xl font-bold text-white mb-4">Special Deals<br>This Season</h2>
                        <p class="text-blue-100 mb-8">Get up to 50% off on selected items. Don't miss out on these amazing deals!</p>
                        <a href="/products?on_sale=1"
                           class="self-start inline-flex items-center gap-2 bg-white text-blue-700 font-semibold px-7 py-3.5 rounded-xl hover:bg-blue-50 transition-colors">
                            Shop Sale
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                    </div>
                    <div class="hidden lg:flex items-end justify-center pt-10 opacity-90">
                        <img src="https://static.vecteezy.com/system/resources/previews/011/993/278/non_2x/3d-render-online-shopping-bag-using-credit-card-or-cash-for-future-use-credit-card-money-financial-security-on-mobile-3d-application-3d-shop-purchase-basket-retail-store-on-e-commerce-free-png.png"
                             alt="" class="max-h-60 object-contain">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== TESTIMONIALS ===================== --}}
    <section class="py-20 bg-gray-50">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <p class="text-sm font-semibold text-blue-600 uppercase tracking-widest mb-3">Reviews</p>
                <h2 class="text-4xl font-bold text-gray-900 mb-4">What Our Customers Say</h2>
                <p class="text-gray-500">Real reviews from real customers who love our products.</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Review 1 --}}
                <div class="bg-white rounded-2xl p-7 border border-gray-100 hover:shadow-md transition-shadow duration-300">
                    <div class="flex gap-1 mb-5">
                        @for ($i = 0; $i < 5; $i++)
                        <svg class="w-4 h-4 text-amber-400 fill-amber-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed mb-6">"Amazing quality and super fast delivery! The website is very easy to navigate. Highly recommend this store to everyone."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center font-semibold text-blue-700 text-sm">AR</div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Adren Roy</p>
                            <p class="text-xs text-gray-400">Verified Buyer</p>
                        </div>
                    </div>
                </div>

                {{-- Review 2 --}}
                <div class="bg-white rounded-2xl p-7 border border-gray-100 hover:shadow-md transition-shadow duration-300">
                    <div class="flex gap-1 mb-5">
                        @for ($i = 0; $i < 5; $i++)
                        <svg class="w-4 h-4 text-amber-400 fill-amber-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed mb-6">"The Filament admin panel is so intuitive. I managed my orders without any hassle. The shopping experience is seamless!"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center font-semibold text-purple-700 text-sm">SR</div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">Sonira Roy</p>
                            <p class="text-xs text-gray-400">Verified Buyer</p>
                        </div>
                    </div>
                </div>

                {{-- Review 3 --}}
                <div class="bg-white rounded-2xl p-7 border border-gray-100 hover:shadow-md transition-shadow duration-300 sm:col-span-2 lg:col-span-1">
                    <div class="flex gap-1 mb-5">
                        @for ($i = 0; $i < 5; $i++)
                        <svg class="w-4 h-4 text-amber-400 fill-amber-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed mb-6">"Responsive design works perfectly on mobile. Payment via Midtrans was super smooth. Will definitely shop here again!"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center font-semibold text-green-700 text-sm">WH</div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">William Harry</p>
                            <p class="text-xs text-gray-400">Verified Buyer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== NEWSLETTER ===================== --}}
    <section class="py-20 bg-white">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mx-auto text-center">
                <p class="text-sm font-semibold text-blue-600 uppercase tracking-widest mb-3">Newsletter</p>
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Stay in the Loop</h2>
                <p class="text-gray-500 mb-8">Get the latest deals, new arrivals, and exclusive offers delivered straight to your inbox.</p>
                <form class="flex gap-3 max-w-md mx-auto">
                    <input
                        type="email"
                        placeholder="Enter your email"
                        class="flex-1 px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl transition-colors whitespace-nowrap">
                        Subscribe
                    </button>
                </form>
                <p class="text-xs text-gray-400 mt-4">No spam, unsubscribe anytime.</p>
            </div>
        </div>
    </section>
</div>