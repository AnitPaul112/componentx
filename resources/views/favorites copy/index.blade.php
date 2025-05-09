@extends('layouts.app')

@section('title', 'My Wishlist')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">My Wishlist</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    @if($favorites->isEmpty())
        <div class="text-center py-12">
            <p class="text-gray-500 text-lg mb-4">Your wishlist is empty.</p>
            <a href="{{ route('products') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                Browse Products
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($favorites as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" alt="{{ $product->product_name }}" 
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-400">No image available</span>
                        </div>
                    @endif

                    <div class="p-4">
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $product->product_name }}</h2>
                        <p class="text-gray-600 mb-4">{{ Str::limit($product->product_description, 100) }}</p>
                        
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-lg font-bold text-blue-600">৳{{ number_format($product->product_price, 2) }}</span>
                        </div>

                        <div class="flex justify-between items-center space-x-2">
                            <a href="{{ route('product.details', ['id' => $product->id]) }}" 
                               class="flex-1 text-center bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                Details
                            </a>
                            
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
                                                class="px-2 py-1 bg-gray-200 rounded-md hover:bg-gray-300">
                                            -
                                        </button>
                                        <span class="mx-2">{{ $cart[$product->id]['quantity'] }}</span>
                                        <button type="submit" name="action" value="increase"
                                                class="px-2 py-1 bg-gray-200 rounded-md hover:bg-gray-300">
                                            +
                                        </button>
                                    </form>
                                </div>
                            @else
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                                        Add to Cart
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('favorites.remove', $product->id) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                                    Remove
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection 