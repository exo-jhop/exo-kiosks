<div class="max-w-3xl mx-auto p-6 flex flex-col h-screen">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">
        🛒 Your Cart
    </h2>

    @if (count($cart))
        <!-- Scrollable cart items -->
        <div class="flex-grow overflow-y-auto space-y-4">
            @foreach ($cart as $item)
                <div class="bg-white rounded-lg shadow-md p-4 flex items-center justify-between">
                    <!-- Image + Item Info -->
                    <div class="flex items-center space-x-4">
                        <img src="{{ Str::startsWith($item['image_path'], 'http') ? $item['image_path'] : asset('storage/' . $item['image_path']) }}"
                            alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded-lg" />

                        <div>
                            <div class="text-lg font-semibold text-gray-800">{{ $item['name'] }}</div>
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                Quantity:
                                <button wire:click="decreaseQuantity({{ $item['id'] }})"
                                    class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">−</button>

                                <span>{{ $item['quantity'] }}</span>

                                <button wire:click="increaseQuantity({{ $item['id'] }})"
                                    class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">+</button>
                            </div>
                        </div>
                    </div>

                    <!-- Price + Remove -->
                    <div class="text-right">
                        <div class="text-sm text-gray-500">Subtotal</div>
                        <div class="text-lg font-bold text-gray-800">
                            ₱{{ number_format($item['price'] * $item['quantity'], 2) }}
                        </div>
                        <button wire:click="removeFromCart({{ $item['id'] }})"
                            class="mt-1 text-sm text-red-600 hover:underline">Remove</button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Sticky footer -->
        <div
            class="mt-4 pt-4 border-t bg-white sticky bottom-0 left-0 right-0 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4 z-20">
            <div class="text-2xl font-bold text-gray-800">
                Total: ₱{{ number_format(collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']), 2) }}
            </div>

            <div class="flex space-x-4">
                <a href="{{ route('home') }}"
                    class="inline-block px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg">
                    ← Back to Main Menu
                </a>

                <button wire:click="checkout"
                    class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow">
                    Checkout
                </button>
            </div>
        </div>

        @if ($showPaymentModal)
            <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                <div class="bg-white p-6 rounded-lg shadow-lg text-center w-80 max-w-full relative">
                    <div class="flex justify-end">
                        <button wire:click="$set('showPaymentModal', false)"
                            class="text-gray-400 hover:text-gray-600 text-2xl font-bold">
                            &times;
                        </button>
                    </div>

                    <h2 class="text-2xl font-bold mb-6 text-gray-800">Choose Payment Method</h2>

                    <button wire:click="confirmCheckout('cash')"
                        class="mb-4 w-full px-4 py-3 bg-gray-800 hover:bg-gray-700 text-white text-lg font-medium rounded-lg transition-colors">
                        Pay at the Counter
                    </button>

                    <button disabled wire:click="confirmCheckout('cashless')"
                        class="w-full px-4 py-3 bg-gray-400 text-white text-lg font-medium rounded-lg cursor-not-allowed opacity-60">
                        Pay with Card / Ewallet
                        <p class="text-xs mt-1 text-gray-300">(Tap, Swipe, QR, or Digital Wallet)</p>
                    </button>
                    <p class="mt-2 text-sm text-red-600 font-semibold">Payment method not available right now.</p>
                </div>
            </div>
        @endif
    @else
        <div class="text-center text-gray-500 text-lg">
            Your cart is empty 🛒
        </div>
        <div class="mt-6 text-center">
            <a href="{{ route('home') }}" class="text-blue-600 hover:underline text-sm">
                ← Back to Products
            </a>
        </div>
    @endif
</div>
