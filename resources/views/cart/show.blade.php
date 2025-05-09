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

    @if(count($cart) > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($cart as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($item['product']->image_url)
                                        <img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->name }}" class="h-16 w-16 object-cover rounded">
                                    @else
                                        <div class="h-16 w-16 bg-gray-200 rounded flex items-center justify-center">
                                            <span class="text-gray-400 text-xs">No image</span>
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $item['product']->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                ${{ number_format($item['product']->price, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('cart.update', $item['product']->id) }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" 
                                           class="w-20 px-2 py-1 border border-gray-300 rounded-md">
                                    <button type="submit" class="text-blue-600 hover:text-blue-800">Update</button>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                ${{ number_format($item['product']->price * $item['quantity'], 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-900">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-8 bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <span class="text-lg font-semibold">Subtotal:</span>
                <span class="text-lg font-bold">${{ number_format($subtotal, 2) }}</span>
            </div>

            <div class="flex justify-between items-center mb-4">
                <span class="text-lg font-semibold">Shipping:</span>
                <span class="text-lg font-bold">${{ number_format($shipping, 2) }}</span>
            </div>

            @if($discount > 0)
                <div class="flex justify-between items-center mb-4">
                    <span class="text-lg font-semibold">Discount:</span>
                    <span class="text-lg font-bold text-green-600">-${{ number_format($discount, 2) }}</span>
                </div>
            @endif

            <div class="border-t border-gray-200 pt-4">
                <div class="flex justify-between items-center">
                    <span class="text-xl font-bold">Total:</span>
                    <span class="text-xl font-bold">${{ number_format($total, 2) }}</span>
                </div>
            </div>

            <div class="mt-6">
                <form action="{{ route('cart.applyCoupon') }}" method="POST" class="flex space-x-2">
                    @csrf
                    <input type="text" name="coupon_code" placeholder="Enter coupon code" 
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-md">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                        Apply Coupon
                    </button>
                </form>
            </div>

            <div class="mt-6 flex justify-end space-x-4">
                <a href="{{ route('products') }}" class="bg-gray-600 text-white px-6 py-2 rounded-md hover:bg-gray-700">
                    Continue Shopping
                </a>
                <a href="{{ route('order.place') }}" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700">
                    Proceed to Checkout
                </a>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500 text-lg mb-4">Your cart is empty.</p>
            <a href="{{ route('products') }}" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                Start Shopping
            </a>
        </div>
    @endif
</div>
@endsection 