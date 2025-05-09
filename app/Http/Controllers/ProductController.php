<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductTag;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Search by name
        if ($request->has('query')) {
            $query->where('product_name', 'like', '%' . $request->query . '%');
        }

        // Filter by category
        if ($request->has('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->whereIn('product_categories.id', $request->category);
            });
        }

        // Filter by tag
        if ($request->has('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->whereIn('product_tags.id', $request->tag);
            });
        }

        // Filter by price range
        if ($request->has('min_price')) {
            $query->where('product_price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('product_price', '<=', $request->max_price);
        }

        // Sort products
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('product_price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('product_price', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('product_name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('product_name', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12);
        $categories = ProductCategory::all();
        $tags = ProductTag::all();

        return view('products', compact('products', 'categories', 'tags'));
    }

    public function show($id)
    {
        $product = Product::with(['categories', 'tags'])->findOrFail($id);
        $relatedProducts = Product::whereHas('categories', function($query) use ($product) {
            $query->whereIn('product_categories.id', $product->categories->pluck('id'));
        })
        ->where('id', '!=', $product->id)
        ->take(4)
        ->get();
        
        return view('product.details', compact('product', 'relatedProducts'));
    }

    public function compare()
    {
        $compareProducts = session('compare', []);
        return view('compare.index', compact('compareProducts'));
    }

    public function addToCompare($productId)
    {
        $product = Product::findOrFail($productId);
        $compareProducts = session('compare', []);

        if (!in_array($productId, array_column($compareProducts, 'id'))) {
            $compareProducts[] = $product;
            session(['compare' => $compareProducts]);
        }

        return redirect()->route('compare.index');
    }

    public function removeFromCompare($productId)
    {
        $compareProducts = session()->get('compare', []);
        $compareProducts = array_filter($compareProducts, function($product) use ($productId) {
            return $product->id != $productId;
        });
        $compareProducts = array_values($compareProducts);
        session()->put('compare', $compareProducts);

        return redirect()->route('compare.index');
    }
}
