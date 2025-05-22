<div class="flex h-screen">
    <!-- Categories Sidebar (Static) -->
    <div class="w-1/4 bg-white shadow-lg overflow-y-auto">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Categories</h2>
        </div>
        <ul class="divide-y divide-gray-200">
            @foreach ($categories as $category)
                <li>
                    <button wire:click="selectCategory({{ $category->id }})"
                        class="w-full px-6 py-4 text-left transition duration-150 font-medium
                    {{ $selectedCategoryId === $category->id
                        ? 'bg-blue-50 text-blue-600'
                        : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset($category->image_path) }}" alt="{{ $category->name }}"
                                class="w-10 h-10 object-cover rounded-full">

                            <span class="text-lg">{{ $category->name }}</span>
                        </div>
                    </button>
                </li>
            @endforeach
        </ul>


    </div>

    <div class="w-3/4 p-6 overflow-y-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Burgers</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="h-48 bg-gray-200 flex items-center justify-center">
                    <svg class="h-20 w-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-1">Classic Burger</h3>
                    <p class="text-gray-600 text-sm mb-2">Juicy beef patty with lettuce and special sauce</p>
                    <div class="flex justify-between items-center mt-3">
                        <span class="font-bold text-gray-800">$8.99</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="h-48 bg-gray-200 flex items-center justify-center">
                    <svg class="h-20 w-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-1">Cheeseburger</h3>
                    <p class="text-gray-600 text-sm mb-2">Classic burger with melted cheese</p>
                    <div class="flex justify-between items-center mt-3">
                        <span class="font-bold text-gray-800">$9.99</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="h-48 bg-gray-200 flex items-center justify-center">
                    <svg class="h-20 w-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-1">Bacon Burger</h3>
                    <p class="text-gray-600 text-sm mb-2">Burger with crispy bacon strips</p>
                    <div class="flex justify-between items-center mt-3">
                        <span class="font-bold text-gray-800">$10.99</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="h-48 bg-gray-200 flex items-center justify-center">
                    <svg class="h-20 w-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-1">Veggie Burger</h3>
                    <p class="text-gray-600 text-sm mb-2">Plant-based patty with fresh veggies</p>
                    <div class="flex justify-between items-center mt-3">
                        <span class="font-bold text-gray-800">$8.49</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Categories Sidebar (Static) -->
        <div class="w-1/4 bg-white shadow-lg overflow-y-auto">
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800">Categories</h2>
            </div>

            <ul class="divide-y divide-gray-200">
                @foreach ($categories as $category)
                    <li>
                        <button class="w-full px-6 py-4 text-left bg-blue-50 text-blue-600 font-medium">
                            <div class="flex items-center">
                                <span class="text-lg">{{ $category['name'] }}</span>
                            </div>
                        </button>
                    </li>
                @endforeach
            </ul>


        </div>

        <!-- Products Grid (Static) -->
        <div class="w-3/4 p-6 overflow-y-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Burgers</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <!-- Static product cards -->
                <div
                    class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        <svg class="h-20 w-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-1">Classic Burger</h3>
                        <p class="text-gray-600 text-sm mb-2">Juicy beef patty with lettuce and special sauce</p>
                        <div class="flex justify-between items-center mt-3">
                            <span class="font-bold text-gray-800">$8.99</span>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        <svg class="h-20 w-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-1">Cheeseburger</h3>
                        <p class="text-gray-600 text-sm mb-2">Classic burger with melted cheese</p>
                        <div class="flex justify-between items-center mt-3">
                            <span class="font-bold text-gray-800">$9.99</span>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        <svg class="h-20 w-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-1">Bacon Burger</h3>
                        <p class="text-gray-600 text-sm mb-2">Burger with crispy bacon strips</p>
                        <div class="flex justify-between items-center mt-3">
                            <span class="font-bold text-gray-800">$10.99</span>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        <svg class="h-20 w-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-1">Veggie Burger</h3>
                        <p class="text-gray-600 text-sm mb-2">Plant-based patty with fresh veggies</p>
                        <div class="flex justify-between items-center mt-3">
                            <span class="font-bold text-gray-800">$8.49</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body> --}}
