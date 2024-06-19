<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Country;
use App\Models\Order;
use App\Models\ShippingCharge;
use App\Models\OrderItem;
use App\Models\CustomerAddress;
use App\Models\DiscountCoupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Cart;
use Carbon\Carbon;

class CartController extends Controller
{
    public function addToCart(Request $request){



        $product = Product::with('product_images')->find($request->id);

        if ($product == null) {
            return response()->json([
                'status' => false,
                'message' => 'Record not Found'
            ]);
        }

        if(Cart::count() > 0){
            $cardContent = Cart::content();
            $productAlradyExist = false;

            foreach ($cardContent as $item) {
                if($item->id == $product->id){
                    $productAlradyExist = true;  
                }

            }


            if($productAlradyExist == false){
                Cart::add($product->id, $product->title, 1, $product->price, ['productImage' => (!empty($product->product_images))? $product->product_images->first() : '' ]);
                $status = true;
                $message = $product->title.' added in cart'; 
                $request->Session()->flash('success', $message);
                
            }else{
                $status = false;
                $message = $product->title.' already added in cart';
            }
          
        }else{
            
            Cart::add($product->id, $product->title, 1, $product->price, ['productImage' => (!empty($product->product_images))? $product->product_images->first() : '' ]);

           $status = true;
           $message = $product->title.' added in cart';


        }

       
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
        
    }

    public function cart(){
        $cardContent = Cart::content();
        // dd($cardContent);
        $data['cardContent'] = $cardContent; 
        return view('front.cart', $data);  
    }

    public function cartUpdate(Request $request){
        $rowId = $request->rowId;
        $qty  = $request->qty;

       
        $itemInfo = Cart::get($rowId);

        $product = Product::find($itemInfo->id);

         if($product->track_qty == 'Yes'){    // track the stock qty on products

            if($qty <= $product->qty){
                Cart::update($rowId, $qty);  // update to cart
                $status = true;
                $message = 'Cart Updated Successfully';
                $request->Session()->flash('success', $message);
            }else{
                $status = false;
                $message = 'Request qty('.$qty.') not avaikable in stock';
                $request->Session()->flash('error', $message); 
            }
         }else{
            Cart::update($rowId, $qty);  // update to cart
            $status = true;
            $message = 'Cart Updated Successfully';
            $request->Session()->flash('success', $message);
         }


       
       


        

        return response()->json([
            'status' => $status,
            'message' => $message
        ]);

    }

    public function deleteItem(Request $request){

        $itemInfo = Cart::get($request->rowId);

        if($itemInfo == null){
            $message = "Item Not Foubd in Cart";
            $request->Session()->flash('error', $message); 
            return response()->json([
                'status' => false,
                'message' => $message
             ]); 
        }


        Cart::remove($request->rowId);
        $message = 'Item Removed From Cart Successfully';
        $request->Session()->flash('success', $message);
        return response()->json([
           'status' => true,
           'message' => $message
        ]);
    }

    public function checkout() {
        // If cart is empty, redirect to cart page
        if (Cart::count() == 0) {
            return redirect()->route('front.cart');
        }

        // If user is not logged in, redirect to login page
        if (!Auth::check()) {
            if (!session()->has('url.intended')) {
                session()->put('url.intended', url()->current());
            }
            return redirect()->route('account.login'); 
        }


        
        
        session()->forget('url.intended'); // Clear the intended URL from the session
        
        $countries = Country::orderBy('name', 'ASC')->get();

        $customerAdress = CustomerAddress::where('user_id', Auth::user()->id)->first();

        $shippingCharge = 0.0;
        $discount = 0;
        $grandtotal = Cart::subtotal(2, '.', ''); 
        $subTotal = Cart::subtotal(2, '.', ''); 

        if(session()->has('coupon')){
            $coupon = session()->get('coupon'); 
            if($coupon->type == 'percent'){
              $discount = ($coupon->discount_amount/100)*$subTotal;
            }else{
              $discount = $coupon->discount_amount;
            }
        }

        if($customerAdress != null){

            $usercoutry = $customerAdress->country_id;
            
            $totalQty = 0;
            foreach (Cart::content() as $item) {
                $totalQty += $item->qty; 
            } 

            $shippingInfo = ShippingCharge::where('country_id', $usercoutry)->first();
            if($shippingInfo != null){
                $shippingCharge = $totalQty * $shippingInfo->amount; 
                $grandtotal  = ($subTotal - $discount)  + $shippingCharge;
            }else{
                $shippingInfo = ShippingCharge::where('country_id', 'rest_of_word')->first(); 
                $shippingCharge = $totalQty * $shippingInfo->amount; 
                $grandtotal  = ($subTotal - $discount)  + $shippingCharge;
            }
            
        }
        
        //calculate shipping charge

        return view('front.checkout', [
            'countries' => $countries,
            'customerAdress' => $customerAdress,
            'shippingCharge' => number_format($shippingCharge, 2),
            'grandtotal' => number_format($grandtotal, 2),
            'discount' => $discount,
        ]);
    }



    public function processChackout(Request $request){
      
     
        //1. Apply validation

        $validator = Validator::make($request->all(),[
            'first_name' => 'required|min:3',
            'last_name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'country' => 'required',
            'address' => 'required|min:30',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'appartment' =>'nullable',
            'order_notes' => 'nullable',


        ]);

        if($validator->fails()){

           return response()->json([
            'status' => false,
            'message' => 'Please fix the error',
            'errors'  => $validator->errors()
           ]);
        }
 
        // 2. save user address
        
        $user = Auth::user();
        
        
        
        // $customerAdress = CustomerAddress::find();
       
  
        CustomerAddress::updateOrCreate(
            ['user_id' => $user->id],
            [
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'country_id' => $request->country,
                'address' => $request->address,
                'apartment' => $request->apartment,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
                'notes' => $request->order_notes
               
            ],
        );
    

        // 3. store data in order table

        if($request->payment_type == 'cod'){

        //    $discountId = '';
           $discountCode = '';
           $shippingCharge = 0;
           $discount = 0;
           $subTotal = Cart::subtotal(2,'.', '');
           $grandTotal = $subTotal;


                // Apply here descount coupon
            if(session()->has('coupon')){
                $coupon = session()->get('coupon'); 
                if($coupon->type == 'percent'){
                $discount = ($coupon->discount_amount/100)*$subTotal;
                }else{
                $discount = $coupon->discount_amount;
                }

                // $discountId = $coupon->id;
                $discountCode = $coupon->code;
            }

           $totalQty = 0;
           foreach (Cart::content() as $item) {    // count the item qty in cart
               $totalQty += $item->qty; 
           } 
           
           $shippingInfo = ShippingCharge::where('country_id', $request->country)->first();  
           
           if($shippingInfo != null){     
               $shippingCharge = $totalQty * $shippingInfo->amount;
               $grandTotal = ($subTotal - $discount) + $shippingCharge;
           }else{
               $shippingInfo = ShippingCharge::where('country_id', 'rest_of_word')->first();
               $shippingCharge = $totalQty * $shippingInfo->amount;
               $grandTotal = ( $subTotal - $discount ) + $shippingCharge;
           }

      


           $order = new Order();
           $order->user_id = $user->id;
           $order->subtotal =  $subTotal;
           $order->shipping = $shippingCharge;
           $order->descount = $discount;
           $order->grand_total = $grandTotal;
           $order->coupon_code =  $discountCode;
        //    $order->coupon_id =   $discountId;

           // order adress
           $order->first_name =$request->first_name;
           $order->last_name =$request->last_name;
           $order->email =$request->email;
           $order->mobile =$request->mobile;
           $order->country_id = $request->country;
           $order->address =$request->address;
           $order->apartment =$request->apartment;
           $order->city =$request->city;
           $order->state =$request->state;
           $order->zip =$request->zip;
           $order->notes =$request->notes;
           $order->save();



            
          // 4. store order item in order item table

           foreach (Cart::content() as  $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $item->id;
            $orderItem->name = $item->name;
            $orderItem->qty = $item->qty;
            $orderItem->price = $item->price;
            $orderItem->total = $item->price * $item->qty;  // total price = price * qty
            $orderItem->save();

            // update product stoc;
            
            $productData = Product::find($item->id);
          

            if($productData->track_qty == 'Yes'){

                if($productData->qty > 0){

                  $currentqty = $productData->qty;
                  $updatedqty = $currentqty - $item->qty;
                  $productData->qty = $updatedqty;
                  $productData->save();

                }else{
                    return response()->json([
                        'status' => false,
                        'message' => $productData->title.'Product Of Stock'
                    ]);
                }
            }

           }

           orderEmail($order->id);

           $request->session()->flash('success', 'You Have Successfully Placed Your Order');


           if(session()->has('coupon')){
             session()->forget('coupon');
           }
           Cart::destroy();

           return response()->json([
               'status' => true,
               'orderId' => $order->id,
               'message' => 'Address saved successfully'
           ]);

        }else{
           
            

        }



       

       
    }

    public function thankyou($orderId){
        return view('front.thankyou',['orderId' => $orderId]);
    }

    public function getOrderSummery(Request $request){
        
        $subTotal = Cart::subtotal(2, '.', '');
        $discount = 0.0;
        $discountString = '';

        // Apply here descount coupon
        if(session()->has('coupon')){
          $coupon = session()->get('coupon'); 
          if($coupon->type == 'percent'){
            $discount = ($coupon->discount_amount/100)*$subTotal;
          }else{
            $discount = $coupon->discount_amount;
          }

          $discountAmount = $coupon->type == 'percent' ? $coupon->discount_amount . '%' : '₹' . $coupon->discount_amount;


            // Generate the discount string
            $discountString = '<div class="col-md-5 gap-0 m-0 p-0">
                <strong>' . $coupon->code . '</strong>
                <a class="btn-sm btn-danger" id="removeCoupon"><i class="fa fa-times"></i></a>
            </div>
            <div class="col-md-7 gap-0 m-0 p-0">
                <span class="text-success">Congratulations! You got ' . $discountAmount . ' discount.</span>
            </div>';

        }
       
        
        if($request->country_id > 0){  // check user country select or not
            
            $totalQty = 0;
            foreach (Cart::content() as $item) {    // count the item qty in cart
                $totalQty += $item->qty; 
            } 
            
            $shippingInfo = ShippingCharge::where('country_id', $request->country_id)->first();  
            
            if($shippingInfo != null){     

                $shippingCharge = $totalQty * $shippingInfo->amount;
                $grandTotal = ($subTotal - $discount) + $shippingCharge;

                return response()->json([
                    'status' => true,
                    'grandTotal' => number_format($grandTotal, 2),
                    'shippingCharge' => number_format($shippingCharge, 2),
                    'discount' => $discount,
                    'discountString' => $discountString,
                ]);

            }else{
               
                $shippingInfo = ShippingCharge::where('country_id', 'rest_of_word')->first();
                
                $shippingCharge = $totalQty * $shippingInfo->amount;
                $grandTotal = ( $subTotal - $discount ) + $shippingCharge;

                return response()->json([
                    'status' => true,
                    'grandTotal' => number_format($grandTotal, 2),
                    'shippingCharge' => number_format($shippingCharge, 2),
                    'discount' => $discount,
                    'discountString' => $discountString,
                ]);

            }


        }else{
            $grandTotal = $subTotal - $discount;
            return response()->json([
                'status' => true,
                'grandTotal' => number_format($grandTotal, 2),
                'shippingCharge' => number_format(0,2),
                'discount' => $discount,
                'discountString' => $discountString,

            ]);
        }
    }


    public function applyDiscount(Request $request) {
        $coupon = DiscountCoupon::where('code', $request->coupon_code)->first();
    
        if ($coupon == null) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid discount coupon'
            ]);
        }
    
        // Set the default timezone to IST (Asia/Kolkata)
        date_default_timezone_set('Asia/Kolkata');
        $now = Carbon::now();
    
        // Check the start date
        if ($coupon->start_at) {
            try {
                $startDate = Carbon::parse($coupon->start_at);
                if ($now->lt($startDate)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Discount coupon is not yet valid'
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Error in discount coupon start date'
                ]);
            }
        }
    
        // Check the expiration date
        if ($coupon->expires_at) {
            try {
                $expireDate = Carbon::parse($coupon->expires_at);
                if ($now->gt($expireDate)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Discount coupon has expired'
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Error in discount coupon expiration date'
                ]);
            }
        }

        if($coupon->max_uses > 0){
      
        // check max uses
        $couponUses = Order::where('coupon_code', $coupon->code)->count();
      
        if($couponUses >= $coupon->max_uses){
            return response()->json([
                'status' => false,
                'message' => 'This coupon is not available'
            ]);
        }
              
       }

       if($coupon->max_uses_user > 0){
          // check max uses by one user
          $couponUsesByUser = Order::where(['coupon_code' => $coupon->code, 'user_id' => Auth::user()->id])->count();
      
          if($couponUsesByUser >= $coupon->max_uses_user){
              return response()->json([
                  'status' => false,
                  'message' => 'You already used this coupon code'
              ]);
          }
        }

        $subTotal = Cart::subtotal(2, '.', '');
       
        if($coupon->min_amount > 0){
        if($subTotal < $coupon->min_amount){  // 3000.0
           
            return response()->json([
                'status' => false,
                'message' => 'Minimun amount must be '.$couponUsesByUser,
            ]);
            
        }
       }
    
        // Apply the coupon
        session()->put('coupon', $coupon);
        return $this->getOrderSummery($request);  //return getOrder summury
    }


    // remove discount coupon

    public function removeDiscount(Request $request){
        
        if(session()->has('coupon')){

            session()->forget('coupon');
            return $this->getOrderSummery($request);

        }else{
            return response()->json([
                'status' => false,
                'message' => 'Coupon not found please try again'
            ]);
        }
    }
    
}
