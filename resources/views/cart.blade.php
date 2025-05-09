@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Shopping Cart</h1>

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

    @php
        $cart = session('cart', []);
        $total = 0;
    @endphp

    @if(empty($cart))
        <div class="text-center py-12">
            <p class="text-gray-500 text-lg mb-4">Your cart is empty.</p>
            <a href="{{ route('products') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                Continue Shopping
            </a>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                @foreach($cart as $id => $item)
                    @if(isset($item['price']) && isset($item['quantity']))
                        @php
                            $total += $item['price'] * $item['quantity'];
                        @endphp
                        <div class="flex items-center justify-between py-4 border-b">
                            <div class="flex items-center">
                                @if(isset($item['image']) && $item['image'])
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] ?? 'Product' }}" class="w-20 h-20 object-cover rounded">
                                @else
                                    <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                                        <span class="text-gray-400">No image</span>
                                    </div>
                                @endif
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $item['name'] ?? 'Product' }}</h3>
                                    <p class="text-gray-600">৳{{ number_format($item['price'], 2) }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" name="action" value="decrease" 
                                            class="px-2 py-1 bg-gray-200 rounded-md hover:bg-gray-300">
                                        -
                                    </button>
                                    <span class="mx-2">{{ $item['quantity'] }}</span>
                                    <button type="submit" name="action" value="increase"
                                            class="px-2 py-1 bg-gray-200 rounded-md hover:bg-gray-300">
                                        +
                                    </button>
                                </form>
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                @endforeach

                <div class="mt-6 flex justify-between items-center">
                    <div class="text-xl font-bold text-gray-800">
                        Total: ৳{{ number_format($total, 2) }}
                    </div>
                    <div class="flex space-x-4">
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700">
                                Clear Cart
                            </button>
                        </form>
                        <form action="{{ route('checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700">
                                Proceed to Checkout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
