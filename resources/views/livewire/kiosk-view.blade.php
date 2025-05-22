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
                <div
                    class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        @if ($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"
                                class="h-full w-full object-cover">
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
</div>
