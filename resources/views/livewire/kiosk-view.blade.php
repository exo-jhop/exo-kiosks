<div>
    @if ($selectedCategoryId === null && !empty($sliders) && $sliders->count())
        <div class="w-full mb-6">
            <div class="relative w-full overflow-hidden rounded-none shadow-md h-64">
                <div class="flex overflow-x-auto space-x-4 p-2 scrollbar-hide"
                     x-data="{ activeSlide: 0 }"
                     x-init="setInterval(() => { activeSlide = (activeSlide + 1) % {{ $sliders->count() }} }, 3000)">
                    @foreach ($sliders as $index => $slider)
                        <div class="flex-shrink-0 w-full"
                             x-show="activeSlide === {{ $index }}"
                             x-transition>
                            <img src="{{ asset('storage/' . $slider->image_path) }}" alt="{{ $slider->title }}"
                               class="w-full h-64 object-cover">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="flex h-screen">
        <div class="w-1/4 bg-white shadow-lg overflow-y-auto h-full thin-scrollbar">

            <div class="p-4 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">Categories</h2>
            </div>
            <ul class="divide-y divide-gray-200">
                <li>
                    <button wire:click="selectCategory(null)"
                        class="w-full px-6 py-4 text-left transition duration-150 font-medium
                    {{ $selectedCategoryId === null ? 'bg-blue-50 text-blue-600' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                            </div>
                            <span class="text-lg">All Products</span>
                        </div>
                    </button>
                </li>
                @foreach ($categories as $category)
                    <li>
                        <button wire:click="selectCategory({{ $category->id }})"
                            class="w-full px-6 py-4 text-left transition duration-150 font-medium
                        {{ $selectedCategoryId === $category->id
                            ? 'bg-blue-50 text-blue-600'
                            : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                            <div class="flex items-center space-x-4">
                                <img src="{{ asset('storage/' . $category->image_path) }}" alt="{{ $category->name }}"
                                    class="w-10 h-10 object-cover rounded-full" />
                                <span class="text-lg">{{ $category->name }}</span>
                            </div>
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="w-3/4 p-6 overflow-y-auto h-full">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                @if ($selectedCategoryId && $selectedCategoryImagePath)
                    <img src="{{ asset('storage/' . $selectedCategoryImagePath) }}" alt="{{ $selectedCategoryName }}"
                        class="w-10 h-10 object-cover rounded-full">
                @endif
                {{ $selectedCategoryName ?? 'All Products' }}
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($products as $product)
                    <div wire:key="product-{{ $product->id }}"
                        class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="h-48 bg-gray-200 flex items-center justify-center">
                            @if ($product->image_path)
                                @if (Str::startsWith($product->image_path, 'http'))
                                    <img src="{{ $product->image_path }}" alt="{{ $product->name }}"
                                        class="h-full w-full object-cover cursor-pointer"
                                        wire:click="openProductModal({{ $product->id }})">
                                @else
                                    <img src="{{ asset('storage/' . $product->image_path) }}"
                                        alt="{{ $product->name }}" class="h-full w-full object-cover cursor-pointer"
                                        wire:click="openProductModal({{ $product->id }})">
                                @endif
                            @else
                                <svg class="h-20 w-20 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-lg mb-1">{{ $product->name }}</h3>
                            <p class="text-gray-600 text-sm mb-2">{{ $product->description }}</p>
                            <div class="flex justify-between items-center mt-3">
                                <span class="font-bold text-gray-800">₱{{ number_format($product->price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 text-lg">No products found in this category.</p>
                    </div>
                @endforelse
            </div>
        </div>
        @if (session()->has('message'))
            <div class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow">
                {{ session('message') }}
            </div>
        @endif
        <a href="{{ route('cart') }}"
            class="fixed bottom-4 right-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow-lg">
            View Cart
        </a>

        <div @class([
            'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 transition-opacity duration-300',
            'hidden' => !$showProductModal || !$selectedProduct,
        ])
            wire:key="product-modal-{{ $selectedProduct ? $selectedProduct->id : 'none' }}">
            @if ($selectedProduct)
                <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
                    <button class="absolute top-2 right-2 text-gray-600 hover:text-gray-900"
                        wire:click="closeProductModal">✕</button>

                    <div class="flex gap-4">
                        <img src="{{ asset('storage/' . $selectedProduct->image_path) }}"
                            class="w-40 h-40 object-cover rounded-lg" alt="{{ $selectedProduct->name }}">
                        <div>
                            <h3 class="text-xl font-bold mb-2">{{ $selectedProduct->name }}</h3>
                            <p class="text-gray-600 mb-4">{{ $selectedProduct->description }}</p>
                            <p class="font-semibold text-gray-800 mb-4">
                                ₱{{ number_format($selectedProduct->price, 2) }}
                            </p>

                            <div class="flex items-center gap-2 mb-4">
                                <label class="text-sm font-medium text-gray-700">Quantity:</label>

                                <div class="flex items-center gap-1">
                                    <button type="button"
                                        class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300"
                                        wire:click="decreaseQuantity">−</button>

                                    <span class="w-8 text-center">{{ $quantity }}</span>

                                    <button type="button"
                                        class="px-3 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300"
                                        wire:click="increaseQuantity">+</button>
                                </div>
                            </div>

                            <button wire:click="addToCart"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Add to Cart
                            </button>

                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
