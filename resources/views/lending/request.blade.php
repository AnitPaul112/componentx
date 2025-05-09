@extends('layouts.app')

@section('title', 'Request to Borrow - ' . $component->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Request to Borrow {{ $component->name }}</h1>

        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <div class="flex items-center space-x-4 mb-6">
                @if($component->image_url)
                    <img src="{{ $component->image_url }}" alt="{{ $component->name }}" class="w-24 h-24 object-cover rounded">
                @else
                    <div class="w-24 h-24 bg-gray-200 rounded flex items-center justify-center">
                        <span class="text-gray-400 text-sm">No image</span>
                    </div>
                @endif
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">{{ $component->name }}</h2>
                    <p class="text-gray-600">Owner: {{ $component->owner->name }}</p>
                    <p class="text-blue-600 font-semibold">Deposit Required: ${{ number_format($component->deposit_amount, 2) }}</p>
                </div>
            </div>

            <form action="{{ route('lending.store-request', $component) }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="start_date" class="block text-gray-700 font-medium mb-2">Start Date</label>
                    <input type="date" name="start_date" id="start_date" required
                        min="{{ date('Y-m-d', strtotime('tomorrow')) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('start_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="end_date" class="block text-gray-700 font-medium mb-2">End Date</label>
                    <input type="date" name="end_date" id="end_date" required
                        min="{{ date('Y-m-d', strtotime('tomorrow')) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('end_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="notes" class="block text-gray-700 font-medium mb-2">Additional Notes (Optional)</label>
                    <textarea name="notes" id="notes" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                    <h3 class="text-yellow-800 font-medium mb-2">Important Information</h3>
                    <ul class="list-disc list-inside text-yellow-700 space-y-1">
                        <li>You will need to pay a deposit of ${{ number_format($component->deposit_amount, 2) }} when picking up the component.</li>
                        <li>The deposit will be returned when you return the component in good condition.</li>
                        <li>Please ensure you can return the component by the end date.</li>
                    </ul>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('lending.show', $component) }}" class="px-6 py-2 text-gray-600 hover:text-gray-800">Cancel</a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');

        startDateInput.addEventListener('change', function() {
            endDateInput.min = this.value;
            if (endDateInput.value && endDateInput.value < this.value) {
                endDateInput.value = this.value;
            }
        });
    });
</script>
@endpush
@endsection 