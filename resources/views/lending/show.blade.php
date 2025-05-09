@extends('layouts.app')

@section('title', $component->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="md:flex">
                <div class="md:w-1/2">
                    @if($component->image_url)
                        <img src="{{ $component->image_url }}" alt="{{ $component->name }}" class="w-full h-96 object-cover">
                    @else
                        <div class="w-full h-96 bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-400">No image available</span>
                        </div>
                    @endif
                </div>

                <div class="md:w-1/2 p-6">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $component->name }}</h1>
                    
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-700 mb-2">Description</h2>
                        <p class="text-gray-600">{{ $component->description }}</p>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-700 mb-2">Owner</h2>
                        <p class="text-gray-600">{{ $component->owner->name }}</p>
                    </div>

                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-700 mb-2">Deposit Required</h2>
                        <p class="text-2xl font-bold text-blue-600">${{ number_format($component->deposit_amount, 2) }}</p>
                    </div>

                    @auth
                        @if($component->user_id !== Auth::id() && $component->is_available)
                            <a href="{{ route('lending.request', $component) }}" 
                               class="block w-full text-center bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700">
                                Request to Borrow
                            </a>
                        @elseif($component->user_id === Auth::id())
                            <div class="space-y-4">
                                <a href="{{ route('lending.my-components') }}" 
                                   class="block w-full text-center bg-gray-600 text-white px-6 py-3 rounded-md hover:bg-gray-700">
                                    Manage My Components
                                </a>
                            </div>
                        @else
                            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                                <span class="block sm:inline">This component is currently not available for lending.</span>
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="block w-full text-center bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700">
                            Login to Request
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 