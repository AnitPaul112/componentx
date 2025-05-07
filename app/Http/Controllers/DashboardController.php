<?php

namespace App\Http\Controllers;

use App\Models\Product;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        // Fetch products from the database
        $products = Product::all();

        // Pass the products to the view
        return view('dashboard', compact('products'));
    }
    public function index(Request $request)
    {
        $query = Product::query();
    
        // Apply search filter
        if ($request->has('search') && $request->search) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }
    
        // Apply brand filter
        if ($request->has('brand') && $request->brand) {
            $query->where('brand', $request->brand);
        }
    
        // Get the filtered products
        $products = $query->get();
    
        return view('dashboard', compact('products'));
    }
    
}
