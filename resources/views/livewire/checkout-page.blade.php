<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
	<h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
		Checkout
	</h1>
	<form wire:submit.prevent='placeOrder'>
		<div class="grid grid-cols-12 gap-4">
			<div class="md:col-span-12 lg:col-span-8 col-span-12">
				<!-- Card -->
				<div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
					<!-- Shipping Address -->
					<div class="mb-6">
						<h2 class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
							Shipping Address
						</h2>
						<div class="grid grid-cols-2 gap-4">
							<div>
								<label class="block text-gray-700 dark:text-white mb-1" for="first_name">
									First Name
								</label>
								<input wire:model='first_name' class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none @error('first_name') border-red-500 @enderror" id="first_name" type="text">
								@error('first_name')
									<div class="text-red-500 text-sm">{{ $message }}</div>
								@enderror
							</div>
							<div>
								<label class="block text-gray-700 dark:text-white mb-1" for="last_name">
									Last Name
								</label>
								<input wire:model='last_name' class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none @error('last_name') border-red-500 @enderror" id="last_name" type="text">
								@error('last_name')
									<div class="text-red-500 text-sm">{{ $message }}</div>
								@enderror
							</div>
						</div>
						<div class="mt-4">
							<label class="block text-gray-700 dark:text-white mb-1" for="phone">
								Phone
							</label>
							<input wire:model='phone' class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none @error('phone') border-red-500 @enderror" id="phone" type="text">
							@error('phone')
								<div class="text-red-500 text-sm">{{ $message }}</div>
							@enderror
						</div>
						<div class="mt-4">
							<label class="block text-gray-700 dark:text-white mb-1" for="address">
								Address
							</label>
							<input wire:model='street_address' class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none @error('street_address') border-red-500 @enderror" id="address" type="text">
							@error('street_address')
								<div class="text-red-500 text-sm">{{ $message }}</div>
							@enderror
						</div>
						<div class="mt-4">
							<label class="block text-gray-700 dark:text-white mb-1" for="city">
								City
							</label>
							<input wire:model='city' class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none @error('city') border-red-500 @enderror" id="city" type="text">
							@error('city')
								<div class="text-red-500 text-sm">{{ $message }}</div>
							@enderror
						</div>
						<div class="grid grid-cols-2 gap-4 mt-4">
							<div>
								<label class="block text-gray-700 dark:text-white mb-1" for="state">
									State
								</label>
								<input wire:model='state' class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none @error('state') border-red-500 @enderror" id="state" type="text">
								@error('state')
									<div class="text-red-500 text-sm">{{ $message }}</div>
								@enderror
							</div>
							<div>
								<label class="block text-gray-700 dark:text-white mb-1" for="zip">
									ZIP Code
								</label>
								<input wire:model='zip_code' class="w-full rounded-lg border py-2 px-3 dark:bg-gray-700 dark:text-white dark:border-none @error('zip_code') border-red-500 @enderror" id="zip" type="text">
								@error('zip_code')
									<div class="text-red-500 text-sm">{{ $message }}</div>
								@enderror
							</div>
						</div>
					</div>
					<div class="text-lg font-semibold mb-4">
						Select Payment Method
					</div>
					<ul class="grid w-full gap-6 md:grid-cols-2">
						<li>
							<!-- UBAH VALUE DARI "cash" MENJADI "cod" -->
							<input wire:model='payment_method' class="hidden peer" id="hosting-small" required type="radio" value="cod" />
							<label class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700" for="hosting-small">
								<div class="block">
									<div class="w-full text-lg font-semibold">Cash on Delivery</div>
								</div>
								<svg aria-hidden="true" class="w-5 h-5 ms-3 rtl:rotate-180" fill="none" viewBox="0 0 14 10" xmlns="http://www.w3.org/2000/svg">
									<path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
								</svg>
							</label>
						</li>
						<li>
							<input wire:model='payment_method' class="hidden peer" id="midtrans" type="radio" value="midtrans">
							<label for="midtrans" class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
								<div class="block">
									<div class="w-full text-lg font-semibold">
										QRIS / Virtual Account (via Midtrans)
									</div>
								</div>
							</label>
						</li>
					</ul>
					@error('payment_method')
						<div class="text-red-500 text-sm">{{ $message }}</div>
					@enderror
				</div>
				<!-- End Card -->
			</div>
			<div class="md:col-span-12 lg:col-span-4 col-span-12">
				<div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
					<div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
						ORDER SUMMARY
					</div>
					<div class="flex justify-between mb-2 font-bold">
						<span>Subtotal</span>
						<span>{{ Number::currency($grand_total, 'IDR') }}</span>
					</div>
					<div class="flex justify-between mb-2 font-bold">
						<span>Taxes</span>
						<span>{{ Number::currency(0, 'IDR') }}</span>
					</div>
					<div class="flex justify-between mb-2 font-bold">
						<span>Shipping Cost</span>
						<span>{{ Number::currency(0, 'IDR') }}</span>
					</div>
					<hr class="bg-slate-400 my-4 h-1 rounded">
					<div class="flex justify-between mb-2 font-bold">
						<span>Grand Total</span>
						<span>{{ Number::currency($grand_total, 'IDR') }}</span>
					</div>
				</div>
				<button type="submit" class="bg-green-500 mt-4 w-full p-3 rounded-lg text-lg text-white hover:bg-green-600">
					<span wire:loading.remove>Place Order</span>
					<span wire:loading>Processing...</span>
				</button>
				<div class="bg-white mt-4 rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
					<div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
						BASKET SUMMARY
					</div>
					<ul class="divide-y divide-gray-200 dark:divide-gray-700" role="list">
						@foreach ($cart_items as $ci)
							<li class="py-3 sm:py-4" wire:key='{{ $ci['product_id'] }}'>
								<div class="flex items-center">
									<div class="flex-shrink-0">
										<img alt="{{ $ci['name'] }}" class="w-12 h-12 rounded-full" src="{{ url('storage', $ci['images']) }}">
									</div>
									<div class="flex-1 min-w-0 ms-4">
										<p class="text-sm font-medium text-gray-900 truncate dark:text-white">
											{{ $ci['name'] }}
										</p>
										<p class="text-sm text-gray-500 truncate dark:text-gray-400">
											Quantity: {{ $ci['quantity'] }}
										</p>
									</div>
									<div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
										{{ Number::currency($ci['total_amount'], 'IDR') }}
									</div>
								</div>
							</li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</form>
</div>

@push('scripts')
	@if($snapToken)
		<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
		<script>
			// Tunggu hingga Livewire selesai merender ulang
			document.addEventListener('livewire:load', function() {
				snap.pay('{{ $snapToken }}', {
					onSuccess: function(result) {
						alert('Payment success!');
						window.location.href = '{{ route('success') }}';
					},
					onPending: function(result) {
						alert('Payment pending! Please complete the payment.');
						window.location.href = '{{ route('success') }}';
					},
					onError: function(result) {
						alert('Payment failed: ' + result.status_message);
						window.location.href = '{{ route('cancel') }}';
					},
					onClose: function() {
						alert('You closed the payment popup.');
						window.location.href = '{{ route('cancel') }}';
					}
				});
			});
		</script>
	@endif
@endpush