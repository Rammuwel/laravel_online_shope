<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request){
         
        $users = User::latest();

        // Check if a keyword is provided and adjust the query
        if (!empty($request->get('keyword'))) {
         $keyword = $request->get('keyword');
         $users = $users->where('name', 'like', '%' . $keyword . '%');
       }
 
        // Paginate the results
        $users = $users->paginate(10);
 
       // Return the view with the users
        return view('admin.users.list', compact('users'));
    }


    public function create(Request $request){
        return view('admin.users.create');
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'phone' => 'required|regex:/^[0-9]{10}$/|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);
       


        if($validator->passes()){
           
             $user = new User();

             $user->name = $request->name;
             $user->email = $request->email;
             $user->phone = $request->phone;
             $user->status = $request->status;
             $user->password = $request->password;
            //  $user->role = 1;
             $user->save();


             session()->flash('success',  'User are created successfully.');

             return response()->json([
                 'status' => true,
                 'message' => 'User are created successfully.'
             ]);
        }else{
    
            return response()->json([
                'status' => false,
                'errors' =>  $validator->errors()
            ]);

        }

    }

    public function edit($id){
        
        $user = User::find($id);

        if(!$user){
            session()->flash('success',  'User are created successfully.');
            return redirect()->route('users.index');     
        }


        return view('admin.users.edit', compact('user'));   
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
    
        if (!$user) {
            session()->flash('error', 'User not found.');
            return redirect()->route('users.index');
        }
    
        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:15|unique:users,phone,' . $user->id,
            'status' => 'required|boolean',
            'password' => 'nullable|string|min:6|confirmed',
        ];
    
        // Validate the request
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    
        // Update user details
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
        ]);
    
        // Update password if provided
        if ($request->filled('password')) {

            $user->password = Hash::make($request->password);
            $user->save();
        }
    
        session()->flash('success',  'User Updated successfully.');
        return response()->json([
            'status' => true,
            'message' => 'User updated successfully.',
        ]);
    }
    

    public function destroy(Request $request, $id){
        $user = User::find($id);

        if(!$user){
            session()->flash('error', 'User are already deleted from users');
          return  response()->json([
            'status' => false,
            'message' => 'User are Not Fount'
          ]);
        }

        $user->delete();
        session()->flash('success', 'User are deleted successfully');
        return  response()->json([
            'status' => false,
            'message' => 'User are Not Fount'
          ]);
    }
}
