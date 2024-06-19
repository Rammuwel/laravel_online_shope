<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\OrderItem;
use App\Models\Country;
use App\Models\CustomerAddress;
use App\Mail\forgetPasswordMail;
use Validator;


class AuthController extends Controller
{
    public function login(){
        return view('front.account.login');
    }

   public function register(){
     return view('front.account.register');
   }

   public function processRegister(Request $request){
    //    dd($request);
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'phone' => 'required|regex:/^[0-9]{10}$/|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);


        if($validator->passes()){
            
            $users = new User();

            $users->name = $request->name;
            $users->email = $request->email;
            $users->phone = $request->phone;
            $users->password = $request->password;
            $users->save(); 

            $request->Session()->flash('success', 'You are Register successfully');

            return response()->json([
                'status' => true,
                'message' => 'You are Register successfully'
            ]);
        }else {

            
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
                'message' => 'something went to rong'
            ]);
        }
   }  

    public function authenticate(Request $request) {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->passes()) {

            // Attempt to log the user in
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
              
                if (session()->has('url.intended')) {
                    return redirect(session()->get('url.intended'));
                }
                return redirect()->route('account.profile')->with('success', 'Login successfully');
            } else {
                return redirect()->route('account.login')
                    ->with('error', 'Email or Password invalid')
                    ->withInput($request->only('email'));
            }
        } else {
            return redirect()->route('account.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }

    public function profile() {

        $user = Auth::user();
        $countries = Country::all();
        $customerAddress = CustomerAddress::where('user_id', $user->id)->first();

        return view('front.profile', compact('user', 'countries', 'customerAddress'));
    
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('account.login')->with('success', 'You are logged out successfully');
    }

    public function orders(){

        $user = Auth::user();

        $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();

        $data['orders'] = $orders;

        return view('front.account.order', $data);
    }


    public function orderDetails($id){
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)->where('id', $id)->first();
        $orderItems = OrderItem::where('order_id', $id)->get();
        $itemsCount = OrderItem::where('order_id', $id)->count();
        $data['order'] = $order;
        $data['orderItems'] = $orderItems;
        $data['itemsCount'] = $itemsCount;

        return view('front.account.order-details', $data);  
    }

    public function wishlist(){
        $data = [];
        $wishlist = Wishlist::where('user_id', Auth::user()->id)->with('product')->get();
        $data['wishlist'] = $wishlist;
        return view('front.account.wishlist', $data);
    }


    public function removeWishProduct(Request $request){

        $wishProduc = Wishlist::find($request->id);

        if(!$wishProduc){
            session()->flash('error', 'Product already Romoved  form wishlist.');
            return response()->json([
                'status' => false,
                'message' => 'Product not Found in Wishlist'
            ]);
        }
        $wishProduc->delete();
        session()->flash('success', 'Product Romoved successfully form wishlist.');
        return response()->json([
            'status' => true,
            'message' => 'Product Romoved successfully form wishlist.'
        ]);
        
    }
    public function updateProfile(Request $request)
    {
       
        $user = User::where('id', Auth::user()->id)->first();
      

    
        if (!$user) {
            abort(404, 'User Not Found');
        }
    
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:15|unique:users,phone,'. $user->id,
            'address' => 'required|string|max:500',
            'country' => 'required|integer',
            'apartment' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:10',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }
    
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone
        ]);
    
        $customerAddress = CustomerAddress::updateOrCreate(
            ['user_id' => $user->id],
            [
                'country_id' => $request->country,
                'address' => $request->address,
                'apartment' => $request->apartment,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
            ]
        );
    
        // Optionally, you can use session flash messages for success feedback
        session()->flash('success', 'Profile Updated Successfully.');
    
        return response()->json([
            'success' => true,
            'message' => 'Profile Updated Successfully.'
        ]);
    }
    

    public function changePassword(){
        
        return view('front.account.change-password');
    }

    public function processChangePassword(Request $request){

        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'new_password' =>  'required|min:5|max:255',
            'confirm_password' => 'required|same:new_password'
        ]);

       if( $validator->passes() ){
         $user = User::select('id', 'password')->where('id', Auth::user()->id)->first();

         
         if(Hash::check($request->new_password, $user->password)){

            User::where('id', $user->id)->update([
               'password' => Hash::make($request->new_password),
            ]);

            session()->flash('success', 'Password Changed Successfully');
            return response()->json([
                'status' => true,
                'message' => 'Password Changed Successfully'
             ]);
              
         }else{
            session()->flash('error', 'Old password not match try again');
            return response()->json([
                'status' => true,
                'message' => 'Old password not match try again'
             ]);
         }

       }else{

        return response()->json([
           'status' => false,
           'errors' => $validator->errors()
        ]);
       }
        
        
    }

    public function forgetFassword(){
        return view('front.account.forget-password');
    }
    public function processForgetFassword(Request $request){
        
        $validator = Validator::make($request->all(), [
             'email' => 'required|email|exists:users,email',
        ]);


        if($validator->fails()){

            return redirect()->route('account.forgetFassword')
            ->withErrors($validator)
            ->withInput($request->only('email')); 
        }
  
        $token = Str::random(60);

         // Update or insert the token
        \DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );


        // Fetch the user
        $user = User::where('email', $request->email)->first();


        $mailData = [
            'token' => $token,
            'user' => $user
        ];

        // Send the email
        Mail::to($request->email)->send(new forgetPasswordMail($mailData));
        

         return redirect()->back()
        ->with('success', 'We have emailed your password reset link!');
   
    }


    public function resetPassword($token){
         $tokenExists = \DB::table('password_reset_tokens')->where('token', $token)->first();

         if($tokenExists == null){
            return redirect()->route('account.forgetFassword')->with('error', 'Invalid Request try again.');
         }
          return view('front.account.reset-password', ['token' => $token]);
    }

    public function resetPasswordProcess(Request $request){
        $token = $request->token;
        $tokenObj = DB::table('password_reset_tokens')->where('token', $token)->first();
        if($tokenObj == null){
        return redirect()->route('account.forgetFassword')->with('error', 'Invalid Request try again.');
        }

        $validator = Validator::make($request->all(), [
        'password' => 'required|min:5',
        'confirm_password' => 'required|same:password'
        ]);


        if($validator->fails()){
            return redirect()->route('front.resetPassword', $token)
            ->withErrors($validator); 
        }

        $user = User::where('email', $tokenObj->email)->first();

        if(!$user){
            abort(404, 'Not Found');
        }

        User::where('id', $user->id)->update([
            'password' => Hash::make($request->password),
        ]);
    

        return redirect()->route('account.login')
        ->with('success', 'You have successfully reset your password.');
        







    }
     
   
}