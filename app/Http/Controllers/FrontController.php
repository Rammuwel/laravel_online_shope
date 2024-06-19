<?php

namespace App\Http\Controllers;

use App\Mail\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use App\Models\Page;
use Validator;
// use App\Models\Product;

class FrontController extends Controller
{
    public function index(){

        $data[] = "";
        $products = Product::where('is_featured', 'Yes')->orderBy('id', 'DESC')->where('status', 1)->take(8)->get();    
        $data['products'] = $products;
        $latestProducts = Product::orderBy('id', 'DESC')->where('status', 1)->take(8)->get();
        $data['latestProducts'] = $latestProducts; 
        return view('front.home', $data);
    }


    // public function shop(){

    //     return view('front.shop');
    // }




    public function addToWishlist(Request $request){
        if (!Auth::check()) {
            session(['url.intended' => url()->previous()]);
            return response()->json([
                'status' => false,
                'message' => 'You are not logged in'
            ]);
        }

        $product = Product::where('id', $request->id)->first();

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => '<div class="alert alert-danger">Product Not Found</div>'
            ]); 
        }

        Wishlist::updateOrCreate(
            [
                'user_id' => Auth::user()->id,
                'product_id' => $request->id
                
            ],
            [
                'user_id' => Auth::user()->id,
                'product_id' => $request->id   
            ]
        );

        // $wishlist = new Wishlist();
        // $wishlist->user_id = Auth::user()->id;
        // $wishlist->product_id = $request->id;
        // $wishlist->save();

        return response()->json([
            'status' => true,
            'message' => '<div class="alert alert-success">"'.$product->title.'" added in wish list</div>'
        ]);
    }


    

    // show static pages

    public function page($slug){

        $page = Page::where('slug', $slug)->first();


        if(!$page){
            abort(404, 'Not Found!');
        }

        return view('front.page', ['page' => $page]);
    }

    
    public function contactUs(Request $request){
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'subject' => 'required|max:255',
            'message' => 'required',
        ]);

        
        if($validator->passes()){

            $maiData = [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'mail_subject' => 'You have received a contact Email'
            ];

            $admin = User::where('id', 1)->first(); //need to create a setting but just use directtly

            Mail::to($admin->email)->send(new ContactUs($maiData));

            session()->flash('success', 'Your Inquiry message send successfully');
            return response()->json([
                'status' => true,
                'message' => 'Your Inquiry message send successfully'
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);


        }

    }
  
}
  