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
            ->where('products.product_id', '!=', null) // Only get favorites with existing products
            ->get();

        return view('favorites.index', compact('favorites'));
    }

    public function add(Product $product)
    {
        $user = auth()->user();
        
        // Check if already in favorites
        if (!$user->favoriteProducts()->where('product_id', $product->product_id)->exists()) {
            $user->favoriteProducts()->attach($product->product_id);
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product added to wishlist successfully.',
                    'inWishlist' => true
                ]);
            }
            
            return redirect()->back()->with('success', 'Product added to wishlist successfully.');
        }
        
        if (request()->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Product is already in your wishlist.',
                'inWishlist' => true
            ]);
        }
        
        return redirect()->back()->with('error', 'Product is already in your wishlist.');
    }

    public function remove(Product $product)
    {
        auth()->user()->favoriteProducts()->detach($product->product_id);
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product removed from wishlist successfully.',
                'inWishlist' => false
            ]);
        }
        
        return redirect()->back()->with('success', 'Product removed from wishlist successfully.');
    }
} 