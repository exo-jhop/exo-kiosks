<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md border border-gray-200">
    <h1 class="text-3xl font-extrabold mb-6 text-gray-900">
        Order <span class="text-indigo-600">#{{ $order->order_number }}</span>
    </h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-gray-700">
        <div>
            <p class="mb-2"><span class="font-semibold">Status:</span>
                <span
                    class="inline-block px-3 py-1 rounded-full text-sm font-medium
                    {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                    {{ ucfirst($order->status) }}
                </span>
            </p>
            <p class="mb-2"><span class="font-semibold">Payment Method:</span> {{ ucfirst($order->payment_method) }}</p>
            <p class="mb-2"><span class="font-semibold">Payment Status:</span>
                <span class="{{ $order->payment_status === 'unpaid' ? 'text-red-600' : 'text-green-600' }}">
                    {{ ucfirst($order->payment_status) }}
                </span>
            </p>
        </div>

        <div class="text-right sm:text-left">
            <p class="text-xl font-bold text-gray-900">
                Total Price: <span class="text-indigo-600">₱{{ number_format($order->total_price, 2) }}</span>
            </p>
        </div>
    </div>

    <h2 class="mt-10 mb-4 text-xl font-semibold text-gray-800 border-b border-gray-200 pb-2">
        Items in Your Order
    </h2>

    <ul class="divide-y divide-gray-200">
        @foreach ($order->items as $item)
            <li class="py-4 flex justify-between items-center hover:bg-gray-50 rounded px-2 transition duration-150">
                <div>
                    <p class="font-medium text-gray-900">{{ $item->product->name }}</p>
                    <p class="text-sm text-gray-500">Quantity: {{ $item->quantity }}</p>
                </div>
                <div class="text-indigo-600 font-semibold text-lg">
                    ₱{{ number_format($item->price * $item->quantity, 2) }}
                </div>
            </li>
        @endforeach
    </ul>
</div>
