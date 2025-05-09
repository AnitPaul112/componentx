@extends('layouts.app')

@section('title', $product->product_name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="md:flex">
            <!-- Product Image -->
            <div class="md:w-1/2">
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->product_name }}" 
                         class="w-full h-96 object-cover">
                @else
                    <div class="w-full h-96 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-400">No image available</span>
                    </div>
                @endif
            </div>

            <!-- Product Details -->
            <div class="md:w-1/2 p-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $product->product_name }}</h1>
                
                <div class="mb-6">
                    <span class="text-2xl font-bold text-blue-600">৳{{ number_format($product->product_price, 2) }}</span>
                </div>

                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Description</h2>
                    <p class="text-gray-600">{{ $product->product_description }}</p>
                </div>

                @if($product->how_to_use)
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-2">How to Use</h2>
                        <p class="text-gray-600">{{ $product->how_to_use }}</p>
                    </div>
                @endif

                @if($product->product_ingredients)
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-2">Ingredients</h2>
                        <p class="text-gray-600">{{ $product->product_ingredients }}</p>
                    </div>
                @endif

                <!-- Categories and Tags -->
                <div class="mb-6">
                    <div class="flex flex-wrap gap-2">
                        @foreach($product->categories as $category)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $category->name }}
                            </span>
                        @endforeach
                        @foreach($product->tags as $tag)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-4">
                    @auth
                        @php
                            $cart = session('cart', []);
                            $inCart = isset($cart[$product->id]);
                        @endphp

                        @if($inCart)
                            <div class="flex-1 flex items-center justify-center space-x-2">
                                <form action="{{ route('cart.update', $product->id) }}" method="POST" class="flex items-center">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" name="action" value="decrease" 
                                            class="px-3 py-2 bg-gray-200 rounded-md hover:bg-gray-300">
                                        -
                                    </button>
                                    <span class="mx-4 text-lg font-semibold">{{ $cart[$product->id]['quantity'] }}</span>
                                    <button type="submit" name="action" value="increase"
                                            class="px-3 py-2 bg-gray-200 rounded-md hover:bg-gray-300">
                                        +
                                    </button>
                                </form>
                            </div>
                        @else
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700">
                                    Add to Cart
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('favorites.add', $product->id) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full bg-red-600 text-white px-6 py-3 rounded-md hover:bg-red-700">
                                Add to Wishlist
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="flex-1 text-center bg-gray-600 text-white px-6 py-3 rounded-md hover:bg-gray-700">
                            Login to Buy
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Related Products</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        @if($relatedProduct->image_url)
                            <img src="{{ $relatedProduct->image_url }}" alt="{{ $relatedProduct->product_name }}" 
                                 class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400">No image available</span>
                            </div>
                        @endif

                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $relatedProduct->product_name }}</h3>
                            <p class="text-gray-600 mb-4">{{ Str::limit($relatedProduct->product_description, 100) }}</p>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-blue-600">৳{{ number_format($relatedProduct->product_price, 2) }}</span>
                                <a href="{{ route('product.details', ['id' => $relatedProduct->id]) }}" 
                                   class="text-blue-600 hover:text-blue-800">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection 