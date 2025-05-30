<div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
        @foreach ($orders as $order)
            <div
                class="flex flex-col justify-between p-6 bg-white dark:bg-gray-900 rounded-2xl shadow-lg dark:shadow-black/70
                       hover:shadow-xl dark:hover:shadow-black/90 transition-shadow duration-300 transform hover:-translate-y-1">
                <div>
                    <h3 class="font-extrabold text-2xl tracking-wide text-gray-900 dark:text-gray-100 mb-4">
                        Order #{{ $order->order_number }}
                    </h3>

                    @php
                        $statuses = ['pending' => 0, 'preparing' => 1, 'ready' => 2];
                        $currentStep = $statuses[$order->status] ?? 0;
                        $steps = ['Pending', 'Preparing', 'Ready'];
                    @endphp

                    <div class="flex justify-between items-center mt-4 mb-2">
                        @foreach ($steps as $index => $label)
                            <div class="flex-1 flex items-center">
                                <div
                                    class="w-8 h-8 flex items-center justify-center rounded-full text-sm font-bold
                                    {{ $index < $currentStep
                                        ? 'bg-green-500 text-white'
                                        : ($index === $currentStep
                                            ? 'bg-blue-500 text-white'
                                            : 'bg-gray-300 text-gray-700 dark:bg-gray-600 dark:text-gray-300') }}">
                                    @if ($index < $currentStep)
                                        ✓
                                    @else
                                        {{ $index + 1 }}
                                    @endif
                                </div>

                                @if ($index < count($steps) - 1)
                                    <div
                                        class="flex-1 h-1 mx-2
                                        {{ $index < $currentStep ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-600' }}">
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="flex justify-between mt-2 text-xs text-gray-500 dark:text-gray-400 px-1">
                        @foreach ($steps as $label)
                            <span class="w-1/3 text-center">{{ $label }}</span>
                        @endforeach
                    </div>

                    <p class="mt-4 mb-3 text-lg text-gray-700 dark:text-gray-300">
                        <span class="font-semibold">Total Price:</span>
                        <span class="text-indigo-600 dark:text-indigo-400 font-bold">
                            ${{ number_format($order->total_price, 2) }}
                        </span>
                    </p>

                    @if ($order->orderItems->count())
                        <div class="mb-4">
                            <p class="font-semibold text-gray-700 dark:text-gray-300 mb-1">Items:</p>
                            <ul class="list-disc list-inside text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                @foreach ($order->orderItems as $item)
                                    <li>
                                        {{ $item->product->name ?? 'Unknown Product' }}
                                        <span class="text-xs text-gray-500">
                                            (x{{ $item->quantity }})
                                            - ${{ number_format($item->subtotal, 2) }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <p class="mb-3">
                        <span class="font-semibold text-gray-700 dark:text-gray-300">Status:</span>
                        <span
                            class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                            {{ $order->status === 'completed'
                                ? 'bg-green-200 text-green-900 dark:bg-green-700 dark:text-green-200'
                                : 'bg-yellow-200 text-yellow-900 dark:bg-yellow-700 dark:text-yellow-200' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>

                    <p class="mb-3 text-gray-700 dark:text-gray-300">
                        <span class="font-semibold">Payment Method:</span> {{ $order->payment_method }}
                    </p>

                    <p class="mb-1">
                        <span class="font-semibold text-gray-700 dark:text-gray-300">Payment Status:</span>
                        <span
                            class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                            {{ $order->payment_status === 'paid'
                                ? 'bg-green-200 text-green-900 dark:bg-green-700 dark:text-green-200'
                                : 'bg-red-200 text-red-900 dark:bg-red-700 dark:text-red-200' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </p>
                </div>

                <div class="mt-6">
                    @if ($order->status === 'pending')
                        <button wire:click="markAsPreparing({{ $order->id }})" wire:loading.attr="disabled"
                            class="w-full px-4 py-2 text-center font-semibold rounded-lg border
                   bg-yellow-500 text-white hover:bg-yellow-600 border-yellow-600
                   dark:bg-yellow-400 dark:hover:bg-yellow-500 dark:border-yellow-500
                   transition duration-200 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed">
                            <span wire:loading.remove>Mark as Preparing</span>
                            <span wire:loading>Updating...</span>
                        </button>
                    @elseif ($order->status === 'preparing')
                        <button wire:click="markAsReady({{ $order->id }})" wire:loading.attr="disabled"
                            class="w-full px-4 py-2 text-center font-semibold rounded-lg border
                   bg-blue-600 text-white hover:bg-blue-700 border-blue-700
                   dark:bg-blue-500 dark:hover:bg-blue-600 dark:border-blue-600
                   transition duration-200 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed">
                            <span wire:loading.remove>Mark as Ready</span>
                            <span wire:loading>Updating...</span>
                        </button>
                    @else
                        <div class="text-center mt-2 text-sm text-emerald-500 dark:text-emerald-400 font-semibold">
                            ✅ Ready
                        </div>
                    @endif
                </div>

                <p class="mt-6 text-xs text-gray-400 dark:text-gray-500 italic text-right select-none">
                    Created: {{ $order->created_at->format('M d, Y') }}
                </p>
            </div>
        @endforeach
    </div>

    <div class="mt-10">
        {{ $orders->links() }}
    </div>
</div>
