<div wire:poll.2000ms id="orders-container">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
        @foreach ($orders as $order)
            <div
                class="flex flex-col justify-between p-6 bg-white dark:bg-gray-900 rounded-2xl shadow-lg dark:shadow-black/70
                       hover:shadow-xl dark:hover:shadow-black/90 transition-shadow duration-300 transform hover:-translate-y-1">
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-extrabold text-2xl tracking-wide text-gray-900 dark:text-gray-100">
                            Order #{{ $order->order_number }}
                        </h3>

                        <span
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-semibold shadow-sm
                            {{ $order->status === 'completed'
                                ? 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100'
                                : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100' }}">
                            @if ($order->status === 'completed')
                                ✅
                            @else
                                ⏳
                            @endif
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    @php
                        $steps = ['Pending', 'Preparing'];
                        $statuses = ['pending' => 0, 'preparing' => 1];
                        $currentStep = $statuses[$order->status] ?? 0;
                    @endphp

                    <div class="flex justify-between items-center mt-4 mb-2">
                        @foreach ($steps as $index => $label)
                            <div class="flex-1 flex flex-col items-center">
                                <div
                                    class="w-8 h-8 flex items-center justify-center rounded-full text-sm font-bold
                {{ $index < $currentStep
                    ? 'bg-green-500 text-white'
                    : ($index === $currentStep
                        ? 'bg-blue-500 text-white animate-spin'
                        : 'bg-gray-300 text-gray-700 dark:bg-gray-600 dark:text-gray-300') }}">
                                    @if ($index < $currentStep)
                                        ✓
                                    @elseif ($index === $currentStep)
                                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                        </svg>
                                    @else
                                        {{ $index + 1 }}
                                    @endif
                                </div>

                                @if ($index < count($steps) - 1)
                                    <div class="flex-1 h-1 w-full mx-2 relative mt-2">
                                        <div class="absolute inset-0 bg-gray-300 dark:bg-gray-600 rounded"></div>

                                        @if ($index === 0 && $currentStep === 1)
                                            <div class="absolute top-0 left-0 h-1 rounded bg-green-500"
                                                style="width: 100%;"></div>
                                        @elseif ($index < $currentStep)
                                            <div class="absolute top-0 left-0 h-1 rounded bg-green-500 w-full"></div>
                                        @endif
                                    </div>
                                @endif

                                <span
                                    class="mt-2 text-xs text-gray-500 dark:text-gray-400 text-center">{{ $label }}</span>
                            </div>
                        @endforeach
                    </div>

                    @if ($order->orderItems->count())
                        <div class="mb-4">
                            <div class="flex items-center justify-between mb-2">
                                <p class="font-semibold text-gray-700 dark:text-gray-300">Items:</p>
                                <button wire:click="resetCompletedItems"
                                    class="text-sm text-red-600 dark:text-red-400 hover:underline">
                                    Reset
                                </button>
                            </div>

                            <ul class="space-y-2">
                                @foreach ($order->orderItems as $item)
                                    <li wire:click="toggleItem({{ $item->id }})" wire:loading.class="opacity-50"
                                        class="flex justify-between items-center bg-gray-100 dark:bg-gray-800 px-3 py-2 rounded-md shadow-sm cursor-pointer transition hover:bg-green-100 dark:hover:bg-green-900">
                                        <span class="font-semibold text-gray-800 dark:text-gray-100">
                                            {{ $item->product->name ?? 'Unknown Product' }}
                                        </span>

                                        @if (in_array($item->id, $completedItems))
                                            <span class="text-green-600 dark:text-green-300 text-lg font-bold">✓</span>
                                        @else
                                            <span
                                                class="inline-block text-xs font-bold bg-blue-200 text-blue-900 dark:bg-blue-700 dark:text-blue-100 px-2 py-0.5 rounded-full">
                                                x{{ $item->quantity }}
                                            </span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
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
