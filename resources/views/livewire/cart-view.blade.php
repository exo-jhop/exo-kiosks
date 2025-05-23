<div>
    <div class="p-6 max-w-xl mx-auto">
        <h2 class="text-2xl font-bold mb-4">🛒 Your Cart</h2>

        @if (count($cart))
            <ul class="divide-y divide-gray-200">
                @foreach ($cart as $item)
                    <li class="py-3 flex justify-between items-center">
                        <div>
                            <div class="font-semibold">{{ $item['name'] }}</div>
                            <div class="text-sm text-gray-600">x{{ $item['quantity'] }}</div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold">₱{{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                            <button wire:click="removeFromCart({{ $item['id'] }})"
                                class="text-red-500 text-xs hover:underline">Remove</button>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="mt-4 text-right font-bold">
                Total: ₱{{ number_format(collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']), 2) }}
            </div>
        @else
            <p class="text-gray-500">Your cart is empty.</p>
        @endif

        <div class="mt-6">
            <a href="{{ route('home') }}" class="text-blue-600 hover:underline">&larr; Back to Products</a>
        </div>
    </div>
</div>
