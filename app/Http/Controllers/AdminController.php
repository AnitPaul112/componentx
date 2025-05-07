<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use App\Models\NewOrder;
use Illuminate\Support\Facades\Auth;
use App\Models\Coupon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $admin = auth()->user();

        return view('admin.dashboard', compact('admin'));
    }

    public function viewUsers()
    {
        // Fetch all users from the users table
        $users = User::all();

        // Return view with users data
        return view('admin.view-users', compact('users'));
    }

    public function viewUser($id)
    {
        // Retrieve user by ID
        $user = User::findOrFail($id);  // If user not found, it will throw a 404

        // Return view with user data
        return view('admin.view-user', compact('user'));
    }
    public function editUser($id)
    {
        // Retrieve user by ID
        $user = User::findOrFail($id);  // If user not found, it will throw a 404

        // Return the edit view with user data
        return view('admin.edit-user', compact('user'));
    }
    public function updateUser(Request $request, $id)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        // Find the user and update
        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email']));

        return redirect()->route('admin.viewUsers')->with('success', 'User updated successfully.');
    }


    public function deleteUser($id)
    {
        // Retrieve user by ID
        $user = User::findOrFail($id);  // If user not found, it will throw a 404

        // Delete the user
        $user->delete();

        // Redirect back to the users list with success message
        return redirect()->route('admin.viewUsers')->with('success', 'User deleted successfully.');
    }

    public function showOrders()
    {
        // Retrieve orders with their associated order items
        $orders = NewOrder::with('orderItems')->get();
        

        return view('admin.orders', compact('orders'));
    
    }

    public function showOrderDetails($orderId)
    {
        // Retrieve the order and its items
        $order = NewOrder::with('orderItems')->findOrFail($orderId);
        
        $orderItems = $order->orderItems->map(function ($item) {
            $product = \DB::table('products')->where('product_id', $item->product_id)->first();
            $item->product_name = $product->product_name;  // Adding product name to the item
            return $item;
        });
        
        // Return view with order details
        return view('admin.order_details', compact('order'));
    }

    public function updateShippingStatus(Request $request, $orderId)
    {
        $order = NewOrder::find($orderId);

        if ($order) {
            $order->shipping_status = $request->input('shipping_status');
            $order->save();
            return redirect()->route('admin.order.details', $orderId)->with('success', 'Shipping status updated successfully.');
        }

        return redirect()->route('admin.orders')->with('error', 'Order not found.');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); 

        return redirect('/admin/login'); 
    }


    public function showDiscounts()
    {
        $coupons = Coupon::all(); // Fetch all records from the coupons table
        return view('admin.discounts', compact('coupons'));
    }
}
