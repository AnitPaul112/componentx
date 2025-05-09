<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Function to display the cart
    public function show()
    {
        $cart = session('cart', []);
        $total = 0;
        $items = [];

        foreach ($cart as $productId => $item) {
            $product = Product::where('product_id', $productId)->first();
            if ($product) {
                $items[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $product->product_price * $item['quantity']
                ];
                $total += $product->product_price * $item['quantity'];
            }
        }

        return view('cart.show', compact('items', 'total'));
    }

    // Function to apply a coupon
    public function applyCoupon(Request $request)
    {
        $coupon = $request->coupon;
        // Add your coupon logic here
        return redirect()->route('cart.show')->with('error', 'Invalid or expired coupon.');
    }

    // Function to update the cart (e.g., add, remove products)
    public function add($productId)
    {
        $product = Product::where('product_id', $productId)->firstOrFail();
        $cart = session('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'quantity' => 1,
                'price' => $product->product_price
            ];
        }

        session(['cart' => $cart]);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully.',
                'cartCount' => array_sum(array_column($cart, 'quantity'))
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully.');
    }

    // Function to remove a product from the cart
    public function remove($productId)
    {
        $cart = session('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session(['cart' => $cart]);
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product removed from cart successfully.',
                'cartCount' => array_sum(array_column($cart, 'quantity'))
            ]);
        }

        return redirect()->back()->with('success', 'Product removed from cart successfully.');
    }

    // Function to update the quantity of a product in the cart
    public function update($productId)
    {
        $cart = session('cart', []);
        $action = request('action');

        if (isset($cart[$productId])) {
            if ($action === 'increase') {
                $cart[$productId]['quantity']++;
            } elseif ($action === 'decrease') {
                $cart[$productId]['quantity']--;
                if ($cart[$productId]['quantity'] <= 0) {
                    unset($cart[$productId]);
                }
            }
        }

        session(['cart' => $cart]);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully.',
                'cartCount' => array_sum(array_column($cart, 'quantity'))
            ]);
        }

        return redirect()->back()->with('success', 'Cart updated successfully.');
    }

    // Function to update the shipping method
    public function updateShippingMethod(Request $request)
    {
        $validated = $request->validate([
            'shipping_method' => 'required|string|in:normal,express',
        ]);

        // Store the selected shipping method in session
        session(['shipping_method' => $validated['shipping_method']]);

        return redirect()->route('cart.show');
    }

    // Function to checkout and place the order
    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if(empty($cart)) {
            return redirect()->route('cart.show')->with('error', 'Your cart is empty.');
        }
        
        return view('checkout');
    }

    public function clear()
    {
        session()->forget('cart');

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully.',
                'cartCount' => 0
            ]);
        }

        return redirect()->back()->with('success', 'Cart cleared successfully.');
    }
}
