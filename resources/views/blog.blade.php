<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800 leading-tight">
            Blog Page
        </h1>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <!-- Blog Form -->
        <div class="form-container bg-black shadow-lg rounded-lg p-6 mb-6">
            <form action="/blog" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="username" class="block font-medium text-gray-700">Username:</label>
                    <input type="text" id="username" name="username" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md" value="{{ Auth::user()->name }}" readonly required>
                </div>
                
                <div class="mb-4">
                    <label for="title" class="block font-medium text-gray-700">Project Name:</label>
                    <input type="text" id="title" name="title" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md" required>
                </div>
                
                <div class="mb-4">
                    <label for="blog_text" class="block font-medium text-gray-700">Project Description:</label>
                    <textarea id="blog_text" name="blog_text" rows="5" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md" required></textarea>
                </div>
                <button type="submit" class="w-full bg-black text-black py-2 rounded-md hover:bg-gray-800">
                    Submit
                </button>


            </form>
        </div>
        <a href="{{ route('viewblogs') }}" class="text-blue-500">View Blogs</a>

        <!-- Success Message -->
        @if (session('success'))
            <p class="success-message text-green-500 text-center font-bold">{{ session('success') }}</p>
        @endif

    </div>

</x-app-layout>
