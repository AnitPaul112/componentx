<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = auth()->user()->favoriteProducts()
            ->where('products.id', '!=', null) // Only get favorites with existing products
            ->get();

        return view('favorites.index', compact('favorites'));
    }

    public function add(Product $product)
    {
        $user = auth()->user();
        
        // Check if already in favorites
        if (!$user->favoriteProducts()->where('product_id', $product->id)->exists()) {
            $user->favoriteProducts()->attach($product->id);
            return redirect()->back()->with('success', 'Product added to wishlist successfully.');
        }
        
        return redirect()->back()->with('error', 'Product is already in your wishlist.');
    }

    public function remove(Product $product)
    {
        auth()->user()->favoriteProducts()->detach($product->id);
        return redirect()->back()->with('success', 'Product removed from wishlist successfully.');
    }
} 