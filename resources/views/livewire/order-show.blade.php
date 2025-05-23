<div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 px-4 py-8 space-y-6">
    <!-- Header -->
    <header class="text-center">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Order Details</h1>
        <p class="text-indigo-600 text-lg font-semibold">
            Order ID: <span class="font-mono bg-indigo-100 px-2 py-1 rounded">{{ $order->order_number }}</span>
        </p>
    </header>

    <!-- Receipt -->
    <div class="max-w-md w-full p-6 bg-white rounded-lg shadow-md border border-gray-300 font-mono text-gray-900">
        <div class="mb-6 text-sm">
            <div class="flex justify-between mb-1">
                <span>Status:</span>
                <span class="{{ $order->status === 'pending' ? 'text-yellow-800' : 'text-green-800' }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            <div class="flex justify-between mb-1">
                <span>Payment Method:</span>
                <span>{{ ucfirst($order->payment_method) }}</span>
            </div>
            <div class="flex justify-between">
                <span>Payment Status:</span>
                <span class="{{ $order->payment_status === 'unpaid' ? 'text-red-700' : 'text-green-700' }}">
                    {{ ucfirst($order->payment_status) }}
                </span>
            </div>
        </div>

        <hr class="border-gray-300 mb-4">

        <ul class="mb-4">
            @foreach ($order->items as $item)
                <li class="flex justify-between py-1">
                    <div class="truncate max-w-xs">
                        <span class="font-semibold">{{ $item->product->name }}</span>
                        <span class="text-xs text-gray-600"> x{{ $item->quantity }}</span>
                    </div>
                    <div class="font-semibold whitespace-nowrap">
                        ₱{{ number_format($item->price * $item->quantity, 2) }}
                    </div>
                </li>
            @endforeach
        </ul>

        <hr class="border-gray-300 mb-4">

        <div class="flex justify-between text-lg font-bold">
            <span>Total:</span>
            <span class="text-indigo-600">₱{{ number_format($order->total_price, 2) }}</span>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center text-gray-600 text-sm italic">
        Please pay your order at the counter.
    </footer>

    <!-- Back Button -->
    <button onclick="window.location.href='{{ url('/') }}'"
        class="mt-4 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors inline-flex items-center">
        <!-- Refresh icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.362 2a9 9 0 11-3.96-7.96" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M20 20v-5h-.581" />
        </svg>
        New Order
    </button>


</div>
