<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Wishlist') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($favorites->isEmpty())
                        <p class="text-center text-gray-500">Your wishlist is empty.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($favorites as $product)
                                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                    <img src="{{ route('product.image', $product->product_id) }}" 
                                         alt="{{ $product->product_name }}" 
                                         class="w-full h-48 object-cover">
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold mb-2">{{ $product->product_name }}</h3>
                                        <p class="text-gray-600 mb-2">${{ $product->product_price }}</p>
                                        <div class="flex justify-between items-center">
                                            <a href="{{ route('product.details', $product->product_id) }}" 
                                               class="text-blue-600 hover:text-blue-800">View Details</a>
                                            <form action="{{ route('favorites.remove', $product->product_id) }}" 
                                                  method="POST" 
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-800"
                                                        title="Remove from wishlist">
                                                    <i class="fas fa-heart"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 