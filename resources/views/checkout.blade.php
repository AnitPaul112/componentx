@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Checkout</h1>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Order Summary -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Order Summary</h2>
            
            @php
                $cart = session('cart', []);
                $total = 0;
            @endphp

            @foreach($cart as $id => $item)
                @php
                    $product = \App\Models\Product::find($id);
                    if ($product) {
                        $subtotal = $product->product_price * $item['quantity'];
                        $total += $subtotal;
                    }
                @endphp
                @if($product)
                    <div class="flex justify-between items-center py-2 border-b">
                        <div>
                            <h3 class="text-gray-800">{{ $product->product_name }}</h3>
                            <p class="text-sm text-gray-600">Quantity: {{ $item['quantity'] }}</p>
                        </div>
                        <span class="text-gray-800">৳{{ number_format($subtotal, 2) }}</span>
                    </div>
                @endif
            @endforeach

            <div class="mt-4 pt-4 border-t">
                <div class="flex justify-between items-center text-lg font-semibold">
                    <span>Total</span>
                    <span>৳{{ number_format($total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Shipping Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Shipping Information</h2>
            
            <form action="{{ route('order.place') }}" method="POST">
                @csrf
                
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="name" id="name" value="{{ auth()->user()->name }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ auth()->user()->email }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="tel" name="phone" id="phone" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Shipping Address</label>
                        <textarea name="address" id="address" rows="3" required
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                    </div>

                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                        <select name="payment_method" id="payment_method" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="cash_on_delivery">Cash on Delivery</option>
                            <option value="bkash">bKash</option>
                        </select>
                    </div>

                    <div id="bkash-details" class="hidden">
                        <div class="space-y-4">
                            <div>
                                <label for="bkash_number" class="block text-sm font-medium text-gray-700">bKash Number</label>
                                <input type="text" name="bkash_number" id="bkash_number"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="transaction_id" class="block text-sm font-medium text-gray-700">Transaction ID</label>
                                <input type="text" name="transaction_id" id="transaction_id"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700">
                        Place Order
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('payment_method').addEventListener('change', function() {
        const bkashDetails = document.getElementById('bkash-details');
        if (this.value === 'bkash') {
            bkashDetails.classList.remove('hidden');
        } else {
            bkashDetails.classList.add('hidden');
        }
    });
</script>
@endpush
@endsection 