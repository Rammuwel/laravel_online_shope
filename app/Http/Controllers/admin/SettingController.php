<?php

namespace App\Http\Controllers\admin;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function changePassword(){

        return view('admin.changePassword');
    }
    public function processChangePassword(Request $request){
       
        $validator = Validator::make($request->all(), [
           'old_password' => 'required|min:5',
           'new_password' => 'required|min:5',
           'confirm_password' => 'required|same:new_password'
        ]);


        if($validator->passes()){

            $admin = User::where('id',Auth::guard('admin')->id())->first();

            if(!Hash::check($request->old_password, $admin->password)){
                session()->flash('error', 'Old passsword Incorrect try again');
                return response()->json([
                    'status' => true,
                    'message' => 'Old passsword are Incorrect try again'
                ]);
            }
         

             $admin->update([
                'password' => Hash::make($request->new_password),
             ]);

             session()->flash('success', 'Password changed Successfully');
            return response()->json([
                'status' => true,
                'message' => 'Password changed Successfully'
            ]);
           }else{

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
       
    }
}
