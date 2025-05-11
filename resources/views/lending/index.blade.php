@extends('layouts.app')

@section('title', 'Lend & Borrow Components')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Available Components for Lending</h1>
        @auth
            <a href="{{ route('lending.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                Add Component for Lending
            </a>
        @endauth
    </div>

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

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($components as $component)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if($component->image_url)
                    <img src="{{ $component->image_url }}" alt="{{ $component->name }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-400">No image available</span>
                    </div>
                @endif

                <div class="p-4">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $component->name }}</h2>
                    <p class="text-gray-600 mb-4">{{ Str::limit($component->description, 100) }}</p>
                    
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-lg font-bold text-blue-600">${{ number_format($component->deposit_amount, 2) }}</span>
                        <span class="text-sm text-gray-500">Deposit Required</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Owner: {{ $component->owner->name }}</span>
                        <a href="{{ route('lending.show', $component) }}" class="text-blue-600 hover:text-blue-800">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">No components available for lending at the moment.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $components->links() }}
    </div>
</div>
@endsection 