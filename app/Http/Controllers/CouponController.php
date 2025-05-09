<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons',
            'discount_percentage' => 'required|numeric|min:1|max:100',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
        ]);

        $coupon = Coupon::create([
            'code' => $request->code,
            'discount_percentage' => $request->discount_percentage,
            'valid_from' => $request->valid_from,
            'valid_until' => $request->valid_until,
        ]);

        return redirect()->route('admin.discounts')->with('success', 'Coupon created successfully!');
    }

    public function applyCoupon(Request $request)
    {
        $coupon = Coupon::where('code', $request->coupon_code)
                        ->where('valid_from', '<=', now())
                        ->where('valid_until', '>=', now())
                        ->first();
    
        if ($coupon) {
            $discount = $coupon->discount_percentage;
            // Apply discount logic, for example:
            $total = $this->calculateTotal() * ((100 - $discount) / 100);
            return redirect()->route('checkout')->with('success', 'Coupon applied! Total: ' . $total);
        }
    
        return redirect()->back()->with('error', 'Invalid or expired coupon');
    }

    public function destroy($id)
    {
        $discount = Coupon::findOrFail($id);
        $discount->delete();
        return redirect()->route('admin.discounts')->with('success', 'Discount deleted successfully');
    }
}
