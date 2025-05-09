<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <!-- Filters Sidebar -->
                        <div class="md:col-span-1">
                            <form action="{{ route('products.index') }}" method="GET" class="space-y-6">
                                <!-- Search -->
                                <div>
                                    <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>

                                <!-- Categories -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Categories</label>
                                    <div class="mt-2 space-y-2">
                                        @foreach($categories as $category)
                                            <div class="flex items-center">
                                                <input type="checkbox" name="category[]" value="{{ $category->id }}"
                                                    {{ in_array($category->id, request('category', [])) ? 'checked' : '' }}
                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                <label class="ml-2 text-sm text-gray-600">{{ $category->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Tags -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tags</label>
                                    <div class="mt-2 space-y-2">
                                        @foreach($tags as $tag)
                                            <div class="flex items-center">
                                                <input type="checkbox" name="tag[]" value="{{ $tag->id }}"
                                                    {{ in_array($tag->id, request('tag', [])) ? 'checked' : '' }}
                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                                <label class="ml-2 text-sm text-gray-600">{{ $tag->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Price Range -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Price Range</label>
                                    <div class="mt-2 grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="min_price" class="sr-only">Min Price</label>
                                            <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}"
                                                placeholder="Min" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        </div>
                                        <div>
                                            <label for="max_price" class="sr-only">Max Price</label>
                                            <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}"
                                                placeholder="Max" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        </div>
                                    </div>
                                </div>

                                <!-- Sort -->
                                <div>
                                    <label for="sort" class="block text-sm font-medium text-gray-700">Sort By</label>
                                    <select name="sort" id="sort" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">Default</option>
                                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name: Z to A</option>
                                    </select>
                                </div>

                                <div>
                                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Apply Filters
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Products Grid -->
                        <div class="md:col-span-3">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($products as $product)
                                    <div class="bg-white rounded-lg shadow overflow-hidden">
                                        @if($product->product_image)
                                            <img src="{{ asset('storage/' . $product->product_image) }}" alt="{{ $product->product_name }}" class="w-full h-48 object-cover">
                                        @endif
                                        <div class="p-4">
                                            <h3 class="text-lg font-medium text-gray-900">{{ $product->product_name }}</h3>
                                            <p class="mt-1 text-sm text-gray-500">{{ Str::limit($product->product_description, 100) }}</p>
                                            <div class="mt-4 flex items-center justify-between">
                                                <span class="text-lg font-medium text-gray-900">${{ number_format($product->product_price, 2) }}</span>
                                                <a href="{{ route('products.show', $product->id) }}" class="text-indigo-600 hover:text-indigo-900">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Pagination -->
                            <div class="mt-6">
                                {{ $products->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 