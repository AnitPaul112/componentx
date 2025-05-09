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
        return view('cart');
    }

    // Function to apply a coupon
    public function applyCoupon(Request $request)
    {
        $coupon = $request->coupon;
        // Add your coupon logic here
        return redirect()->route('cart.show')->with('error', 'Invalid or expired coupon.');
    }

    // Function to update the cart (e.g., add, remove products)
    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);
        
        $cart = session()->get('cart', []);
        
        if(isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->product_name,
                'price' => $product->product_price,
                'image' => $product->image_url,
                'quantity' => 1
            ];
        }
        
        session()->put('cart', $cart);
        
        return redirect()->back()->with('success', 'Product added to cart successfully.');
    }

    // Function to remove a product from the cart
    public function remove($productId)
    {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Product removed from cart successfully.');
    }

    // Function to update the quantity of a product in the cart
    public function updateCart($productId, Request $request)
    {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$productId])) {
            if($request->action === 'increase') {
                $cart[$productId]['quantity']++;
            } else if($request->action === 'decrease') {
                if($cart[$productId]['quantity'] > 1) {
                    $cart[$productId]['quantity']--;
                } else {
                    // If quantity would become 0, remove the item instead
                    unset($cart[$productId]);
                }
            }
            
            session()->put('cart', $cart);
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
        return redirect()->back()->with('success', 'Cart cleared successfully.');
    }
}
