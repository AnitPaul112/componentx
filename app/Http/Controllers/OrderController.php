<?php

namespace App\Http\Controllers;

use App\Models\NewOrder;  // Make sure to import the model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        // Ensure that cart data exists in the session
        $cart = session('cart');
        if (!$cart || count($cart) === 0) {
            return redirect()->route('cart.show')->with('error', 'Your cart is empty.');
        }
    
        // Get the shipping method from session
        $shippingMethod = session('shipping_method', 'normal');
        $shippingCost = $shippingMethod === 'express' ? 150 : 80;
    
        // Calculate the total price including shipping
        $totalPrice = $this->calculateTotalPrice($cart, $shippingCost);
    
        // Apply coupon discount if available
        $couponDiscount = session('coupon_discount', 0);
        if ($couponDiscount > 0) {
            $totalPrice *= ((100 - $couponDiscount) / 100);
        }
    
        // Create the order in the `new_orders` table
        $order = NewOrder::create([
            'user_id' => auth()->user()->id,
            'username' => $request->name,
            'address' => $request->address,
            'total_price' => $totalPrice,
            'payment_method' => $request->payment_method,
            'shipping_status' => 'Pending',
            'products' => json_encode($cart)
        ]);
    
        // Loop through the cart items and add them to the order details
        foreach ($cart as $id => $item) {
            $order->orderItems()->create([
                'product_id' => $id,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }
    
        // Clear the cart session after the order is placed
        session()->forget('cart');

        // Handle payment method
        if ($request->payment_method === 'cash_on_delivery') {
            // Send confirmation email for cash on delivery
            Mail::to($request->email)->send(new OrderConfirmation($order));
            return redirect()->route('order.confirmation', ['order_id' => $order->id])
                           ->with('success', 'Your order has been placed successfully! You will receive a confirmation email shortly.');
        } else if ($request->payment_method === 'bkash') {
            // Generate bKash payment URL
            $bkashUrl = $this->generateBkashPaymentUrl($order);
            return redirect($bkashUrl);
        }
    }

    private function generateBkashPaymentUrl($order)
    {
        // bKash Sandbox credentials
        $appKey = 'YOUR_BKASH_APP_KEY';
        $appSecret = 'YOUR_BKASH_APP_SECRET';
        $merchantNumber = 'YOUR_BKASH_MERCHANT_NUMBER';
        
        // Generate a unique payment ID
        $paymentId = 'PAY-' . time() . '-' . $order->id;
        
        // Store payment ID in session for verification
        session(['bkash_payment_id' => $paymentId]);
        
        // Construct bKash payment URL (sandbox)
        $baseUrl = 'https://checkout.sandbox.bka.sh/v1.2.0-beta/checkout/payment/create';
        
        // In a real implementation, you would:
        // 1. Make an API call to bKash to create a payment
        // 2. Get the payment URL from the response
        // 3. Redirect the user to that URL
        
        // For now, we'll redirect to a mock payment page
        return route('bkash.payment', ['order_id' => $order->id]);
    }

    // Calculate the total price for the cart
    private function calculateTotalPrice($cart, $shippingCost)
    {
        $total = 0;
        $total += $shippingCost;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return $total;
    }

    public function orderConfirmation($order_id)
    {
        // Retrieve the order from the database using the order ID
        $order = NewOrder::findOrFail($order_id);

        $orderItems = $order->orderItems->map(function ($item) {
            $product = \DB::table('products')->where('id', $item->product_id)->first();
            $item->product_name = $product->product_name;  // Adding product name to the item
            return $item;
        });
        
        // Return the order confirmation view, passing the order data
        return view('order.confirmation', compact('order'));
    }

    public function index()
    {
        // Retrieve orders for the logged-in user
        $orders = NewOrder::where('user_id', auth()->id())->get(); 

        // Pass orders to the view
        return view('my_orders', compact('orders'));
    }

    public function showBkashPayment($order_id)
    {
        $order = NewOrder::findOrFail($order_id);
        return view('bkash.payment', compact('order'));
    }

    public function verifyBkashPayment(Request $request, $order_id)
    {
        $order = NewOrder::findOrFail($order_id);
        
        // In a real implementation, you would:
        // 1. Verify the transaction ID with bKash API
        // 2. Update the order status based on the verification result
        
        // For testing purposes, we'll just update the order status
        $order->update([
            'order_status' => 'Paid',
            'payment_status' => 'Completed'
        ]);

        // Send confirmation email
        Mail::to($order->email)->send(new OrderConfirmation($order));

        return redirect()->route('order.confirmation', ['order_id' => $order->id])
                        ->with('success', 'Payment verified successfully! Your order has been confirmed.');
    }
}
