@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Community Blog</h1>
        @auth
            <a href="{{ route('blog.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Write a Post
            </a>
        @endauth
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($blogs as $blog)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if($blog->featured_image)
                    <img src="{{ Storage::url($blog->featured_image) }}" alt="{{ $blog->title }}" class="w-full h-48 object-cover">
                @endif
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <img src="{{ $blog->user->profile_photo_url }}" alt="{{ $blog->user->name }}" class="w-10 h-10 rounded-full">
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">{{ $blog->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $blog->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    
                    <h2 class="text-xl font-semibold mb-2">
                        <a href="{{ route('blog.show', $blog) }}" class="text-gray-900 hover:text-blue-600">
                            {{ $blog->title }}
                        </a>
                    </h2>
                    
                    <p class="text-gray-600 mb-4">
                        {{ Str::limit(strip_tags($blog->content), 150) }}
                    </p>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <button class="vote-button text-gray-500 hover:text-blue-600" data-blog-id="{{ $blog->id }}" data-vote-type="up">
                                <i class="fas fa-arrow-up"></i>
                                <span class="upvote-count">{{ $blog->upvotes }}</span>
                            </button>
                            <button class="vote-button text-gray-500 hover:text-red-600" data-blog-id="{{ $blog->id }}" data-vote-type="down">
                                <i class="fas fa-arrow-down"></i>
                                <span class="downvote-count">{{ $blog->downvotes }}</span>
                            </button>
                        </div>
                        
                        @if($blog->product)
                            <a href="{{ route('products.show', $blog->product) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                Related Product
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $blogs->links() }}
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