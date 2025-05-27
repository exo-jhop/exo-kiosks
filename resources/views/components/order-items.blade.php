@if ($order->orderItems->isNotEmpty())
    <div class="space-y-4 bg-gray-50 dark:bg-gray-800 rounded-xl p-5 shadow-sm max-h-[300px] overflow-y-auto scrollbar-thin"
        style="scrollbar-width: thin; scrollbar-color: #a0aec0 transparent;">
        @foreach ($order->orderItems as $item)
            <div
                class="flex items-center justify-between border-b border-gray-200 dark:border-gray-700 pb-3 last:border-b-0">
                <div class="flex items-center space-x-4">
                    @if ($item->product?->image_path)
                        <img src="{{ asset('storage/' . $item->product->image_path) }}"
                            class="w-12 h-12 object-cover rounded-lg" alt="{{ $item->product->name }}">
                    @else
                        <div class="w-12 h-12 rounded bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400 text-xs font-semibold select-none"
                            aria-label="No image available" role="img">
                            N/A
                        </div>
                    @endif

                    <div>
                        <p class="font-semibold text-sm text-gray-900 dark:text-gray-100 leading-tight">
                            {{ $item->product->name ?? 'Unknown Product' }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Qty: {{ $item->quantity }} &times; ₱{{ number_format($item->price, 2) }}
                        </p>
                    </div>
                </div>
                <div class="text-sm font-semibold text-gray-700 dark:text-gray-200 text-right min-w-[80px]">
                    ₱{{ number_format($item->quantity * $item->price, 2) }}
                </div>
            </div>
        @endforeach


    </div>
    <div
        class="flex justify-between items-center pt-4 border-t border-gray-300 dark:border-gray-600 mt-4 text-xl font-extrabold text-primary-700 dark:text-primary-400">
        <span>Total</span>
        <span>
            ₱{{ number_format($order->orderItems->sum(fn($item) => $item->quantity * $item->price), 2) }}
        </span>
    </div>
@else
    <p class="text-sm text-gray-500 dark:text-gray-400 italic select-none">No items found in this order.</p>
@endif
