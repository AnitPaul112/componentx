@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">bKash Payment</h1>

        <div class="mb-6">
            <p class="text-gray-600">Order #{{ $order->id }}</p>
            <p class="text-xl font-bold text-gray-800">Total Amount: ৳{{ number_format($order->total_amount, 2) }}</p>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <h2 class="text-lg font-semibold mb-4">Payment Instructions</h2>
            <ol class="list-decimal list-inside space-y-2 text-gray-600">
                <li>Open your bKash app</li>
                <li>Send ৳{{ number_format($order->total_amount, 2) }} to: <span class="font-bold">01XXXXXXXXX</span></li>
                <li>Use the reference: <span class="font-bold">ORDER-{{ $order->id }}</span></li>
                <li>After payment, enter the transaction ID below</li>
            </ol>
        </div>

        <form action="{{ route('bkash.verify', ['order_id' => $order->id]) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="transaction_id" class="block text-sm font-medium text-gray-700 mb-2">Transaction ID</label>
                <input type="text" name="transaction_id" id="transaction_id" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Enter bKash transaction ID">
            </div>

            <button type="submit" class="w-full bg-green-600 text-white px-6 py-3 rounded-md hover:bg-green-700">
                Verify Payment
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-500">This is a sandbox environment for testing purposes.</p>
            <p class="text-sm text-gray-500">In production, this would integrate with the actual bKash payment gateway.</p>
        </div>
    </div>
</div>
@endsection 