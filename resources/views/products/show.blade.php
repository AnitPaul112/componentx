<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Product Image -->
                        <div>
                            @if($product->product_image)
                                <img src="{{ asset('storage/' . $product->product_image) }}" alt="{{ $product->product_name }}" class="w-full h-96 object-cover rounded-lg">
                            @endif
                        </div>

                        <!-- Product Details -->
                        <div class="space-y-6">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">{{ $product->product_name }}</h1>
                                <p class="mt-2 text-2xl text-gray-900">${{ number_format($product->product_price, 2) }}</p>
                            </div>

                            <div>
                                <h2 class="text-lg font-medium text-gray-900">Description</h2>
                                <p class="mt-2 text-gray-600">{{ $product->product_description }}</p>
                            </div>

                            @if($product->how_to_use)
                                <div>
                                    <h2 class="text-lg font-medium text-gray-900">How to Use</h2>
                                    <p class="mt-2 text-gray-600">{{ $product->how_to_use }}</p>
                                </div>
                            @endif

                            @if($product->product_ingredients)
                                <div>
                                    <h2 class="text-lg font-medium text-gray-900">Ingredients</h2>
                                    <p class="mt-2 text-gray-600">{{ $product->product_ingredients }}</p>
                                </div>
                            @endif

                            <!-- Categories and Tags -->
                            <div class="flex flex-wrap gap-2">
                                @foreach($product->categories as $category)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                                @foreach($product->tags as $tag)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>

                            <!-- Add to Cart Button -->
                            <div class="mt-6">
                                <button type="button" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Related Products -->
                    @if($relatedProducts->isNotEmpty())
                        <div class="mt-16">
                            <h2 class="text-2xl font-bold text-gray-900">Related Products</h2>
                            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                                @foreach($relatedProducts as $relatedProduct)
                                    <div class="bg-white rounded-lg shadow overflow-hidden">
                                        @if($relatedProduct->product_image)
                                            <img src="{{ asset('storage/' . $relatedProduct->product_image) }}" alt="{{ $relatedProduct->product_name }}" class="w-full h-48 object-cover">
                                        @endif
                                        <div class="p-4">
                                            <h3 class="text-lg font-medium text-gray-900">{{ $relatedProduct->product_name }}</h3>
                                            <p class="mt-1 text-sm text-gray-500">{{ Str::limit($relatedProduct->product_description, 100) }}</p>
                                            <div class="mt-4 flex items-center justify-between">
                                                <span class="text-lg font-medium text-gray-900">${{ number_format($relatedProduct->product_price, 2) }}</span>
                                                <a href="{{ route('products.show', $relatedProduct->id) }}" class="text-indigo-600 hover:text-indigo-900">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 