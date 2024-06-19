<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DiscountCoupon;
use Illuminate\Support\Facades\Validator;

class DiscountCouponController extends Controller
{
    public function index(Request $request)
    {
        $discountCoupons = DiscountCoupon::latest();

        // Check if a keyword is provided and adjust the query
        if ($keyword = $request->get('keyword')) {
            $discountCoupons = $discountCoupons->where('code', 'like', '%' . $keyword . '%')
                                               ->orWhere('name', 'like', '%' . $keyword . '%');
        }

        // Paginate the results
        $discountCoupons = $discountCoupons->paginate(10);

        // Return the view with the discount coupons
        return view('admin.coupons.list', compact('discountCoupons'));
    }


    public function create(){

       return view('admin.coupons.create');
    }


    public function store(Request $request){

          $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:255|unique:discount_coupons,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_uses' => 'nullable|integer',
            'max_uses_user' => 'nullable|integer',
            'type' => 'required|in:percent,fixed',
            'discount_amount' => 'required|numeric|min:0',
            'min_amount' => 'nullable|numeric',
            'status' => 'required|in:active,expired,inactive',
            'start_at' => 'required|date|after_or_equal:today|before:expires_at',
            'expires_at' => 'required|date|after:start_at',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        $coupon = new DiscountCoupon();
        $coupon->code = $request->code;
        $coupon->name = $request->name;
        $coupon->description = $request->description;
        $coupon->max_uses = $request->max_uses;
        $coupon->max_uses_user = $request->max_uses_user;
        $coupon->type = $request->type;
        $coupon->discount_amount = $request->discount_amount;
        $coupon->min_amount = $request->min_amount;
        $coupon->status = $request->status;
        $coupon->start_at = $request->start_at;
        $coupon->expires_at = $request->expires_at;
        $coupon->save();
        
        $request->session()->flash('success', 'Coupon created successfully');
        return response()->json(['status' => true, 'message' => 'Coupon created successfully']);
    

    }

    public function edit($id)
    {
        $coupon = DiscountCoupon::find($id);

        if($coupon == null){
            session()->flash('error', 'Coupon not found');
            return redirect()->route('coupons.index');
        }

        return view('admin.coupons.edit', compact('coupon'));
    }



    public function update($id, Request $request)
    {
        try {
            // Find the coupon by ID
            $coupon = DiscountCoupon::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            $request->session()->flash('error', 'Coupon not found');
            return response()->json(['status' => false, 'Notfound' => true]);
        }

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:255|unique:discount_coupons,code,' . $id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_uses' => 'nullable|integer',
            'max_uses_user' => 'nullable|integer',
            'type' => 'required|in:percent,fixed',
            'discount_amount' => 'required|numeric|min:0',
            'min_amount' => 'nullable|numeric',
            'status' => 'required|in:active,expired,inactive',
            'start_at' => 'required|date|after_or_equal:today|before:expires_at',
            'expires_at' => 'required|date|after:start_at',
        ]);

        // Return validation errors as JSON
        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        // Update the coupon with validated data
        $coupon->update($request->all());

        // Return success response as JSON
        $request->session()->flash('success', 'Coupon updated successfully');
        return response()->json(['status' => true, 'message' => 'Coupon updated successfully']);
    }


    public function destroy($id, Request $request){
        $discountCoupon = DiscountCoupon::find($id);

        if(empty($discountCoupon)){
         $request->session()->flash('error', 'Discount Coupon not found');
         return response()->json([
           'status' => true,
           'message' => 'Discount Coupon not found'
         ]);
        }
      

       //delete category
       $discountCoupon->delete();
        
       $request->session()->flash('success', 'Discount Coupon Deleted Successfully');

       return response()->json([
         'status' => true,
         'message' => 'Discount Coupon Deleted Successfully'
       ]);

    }
}
