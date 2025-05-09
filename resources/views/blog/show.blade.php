@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if($blog->featured_image)
                <img src="{{ Storage::url($blog->featured_image) }}" alt="{{ $blog->title }}" class="w-full h-96 object-cover">
            @endif
            
            <div class="p-8">
                <div class="flex items-center mb-6">
                    <img src="{{ $blog->user->profile_photo_url }}" alt="{{ $blog->user->name }}" class="w-12 h-12 rounded-full">
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">{{ $blog->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $blog->created_at->format('F j, Y') }}</p>
                    </div>
                </div>

                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $blog->title }}</h1>

                <div class="flex items-center space-x-4 mb-8">
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                        {{ ucfirst($blog->category) }}
                    </span>
                    <div class="flex items-center space-x-2">
                        <button class="vote-button text-gray-500 hover:text-blue-600" data-blog-id="{{ $blog->id }}" data-vote-type="up">
                            <i class="fas fa-arrow-up"></i>
                            <span class="upvote-count">{{ $blog->upvotes }}</span>
                        </button>
                        <button class="vote-button text-gray-500 hover:text-red-600" data-blog-id="{{ $blog->id }}" data-vote-type="down">
                            <i class="fas fa-arrow-down"></i>
                            <span class="downvote-count">{{ $blog->downvotes }}</span>
                        </button>
                    </div>
                </div>

                <div class="prose max-w-none mb-8">
                    {!! $blog->content !!}
                </div>

                @if($blog->product)
                    <div class="border-t border-gray-200 pt-6 mt-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Related Product</h3>
                        <div class="flex items-center space-x-4">
                            <img src="{{ $blog->product->image_url }}" alt="{{ $blog->product->name }}" class="w-20 h-20 object-cover rounded">
                            <div>
                                <h4 class="text-lg font-medium text-gray-900">{{ $blog->product->name }}</h4>
                                <p class="text-gray-600">{{ Str::limit($blog->product->description, 100) }}</p>
                                <a href="{{ route('products.show', $blog->product) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                    View Product →
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('.vote-button').forEach(button => {
    button.addEventListener('click', async function() {
        const blogId = this.dataset.blogId;
        const voteType = this.dataset.voteType;
        
        try {
            const response = await fetch(`/blog/${blogId}/vote`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ vote_type: voteType })
            });
            
            const data = await response.json();
            
            // Update vote counts
            this.closest('.flex').querySelector('.upvote-count').textContent = data.upvotes;
            this.closest('.flex').querySelector('.downvote-count').textContent = data.downvotes;
            
        } catch (error) {
            console.error('Error:', error);
        }
    });
});
</script>
@endpush
@endsection 