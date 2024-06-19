<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AdminAuthController extends Controller
{
    public function index(){
        return view('admin.adninLogin');
    }

    public function authenticate(Request $request){
      $validator = Validator::make($request->all(), [
        
        'email' => 'required|email',
        'password' => 'required'
      ]);

      if($validator->passes()){
        
        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remeber'))){
             
             $admin = Auth::guard('admin')->user();
            

            if($admin->role == 2){

                return redirect()->Route('admin.dashboard')->with('success', 'login successfully'); ;
            }
            else{
                Auth::guard('admin')->logout();
                return redirect()->Route('admin.login')->with('error', 'you are not authorized to access this page');    
            }

        }else{
            return redirect()->Route('admin.login')->with('error', ' Email or Password invalid');  
        }

      }else{
        return redirect()->Route('admin.login')
        ->withErrors($validator)
        ->withInput($request->only('email'));
      }
    }


    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->Route('admin.login');
    }
}
