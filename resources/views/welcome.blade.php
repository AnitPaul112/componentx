<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <!-- Navbar -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">EShopBD</h1>
            <ul class="flex space-x-4">
                <li><a href="/login" class="text-gray-600 hover:text-gray-800">Login</a></li>
                <li><a href="/register" class="text-gray-600 hover:text-gray-800">Register</a></li>
                <li><a href="/admin/login" class="text-gray-600 hover:text-gray-800">Admin</a></li>
            </ul>

            <!-- Search Bar -->
            <form action="{{ route('search.products') }}" method="GET" class="flex items-center space-x-2">
                <input type="text" name="query" placeholder="Search products..." class="px-4 py-2 border border-gray-300 rounded-md" value="{{ request()->query('query') }}">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Search</button>
            </form>
       
            <!-- Category Filter Dropdown -->
            <form action="{{ route('home') }}" method="GET" class="flex items-center space-x-2">
                <select name="category" class="p-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-500">
                    <option value="">Filter by Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" {{ $selectedCategory == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="p-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Apply Filter
                </button>
            </form>
            
            <button id="applyFilters" class="p-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-500">
                Apply Filters
            </button>
        </div>
    </nav>

    <!-- Body -->
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6">Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
                <div class="bg-white rounded-lg shadow-md p-4">
                    <img src="{{ route('product.image', $product->product_id) }}" alt="{{ $product->product_name }}">
                    <h3 class="text-lg font-bold text-gray-800">{{ $product->product_name }}</h3>
                    <p class="text-gray-600 mt-2">{{ $product->product_description }}</p>
                    <p class="text-green-600 font-semibold mt-2">&#2547;{{ $product->product_price }}</p>
                    
                    <!-- Details Button -->
                    @if (Auth::check())
                        <a href="{{ route('product.details', $product->product_id) }}" class="mt-4 inline-block bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">View Details</a>
                    @else
                        <a href="{{ route('login') }}" class="mt-4 inline-block bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">View Details</a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
