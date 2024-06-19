<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Country;
use App\Models\ShippingCharge;


class ShippingChargeController extends Controller
{
    public function create(){
        $countries = Country::get();

        $shippingCharges = ShippingCharge::select('shipping_charges.*', 'countries.name as country_name')
        ->leftJoin('countries', 'shipping_charges.country_id', 'countries.id')
        ->orderBy('shipping_charges.country_id', 'DESC')->get();
        
        // dd($shippingCharge);

         $data['countries'] = $countries;
         $data['shippingCharges'] = $shippingCharges;

        return view('admin.shipping.create', $data);
    }

    public function store(Request $request){
        // dd($request);
        $validator = Validator::make($request->all(), [
           'country' => 'required',
           'amount'  => 'required|numeric'
        ]);

        if($validator->passes()){

            
            $count = ShippingCharge::where('country_id', $request->country)->count();
            
            if($count>0){
             $request->session()->flash('error', 'Shipping Charge Already Created');
             return response()->json([
                'status' => true,
                'message' => 'Shipping Charge al already created'
             ]); 
            }
            
            
            $shippingCharge = new ShippingCharge();
            $shippingCharge->country_id = $request->country;
            $shippingCharge->amount = $request->amount;
            $shippingCharge->save();

            $request->session()->flash('success', 'Shipping Charge added successfully');
            return response()->json([
                'status' => true,
                'message' => 'Shipping Charge added successfully'
            ]);

        }else{

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }


    public function edit($id){
        $countries = Country::get();
        $shippingCharge = ShippingCharge::find($id);

        if(empty($shippingCharge)){
           return redirect()->route('shipping.create')->with('error', 'Record Not found');
        }
       
        
        $data['countries'] = $countries;
        $data['shippingCharge'] = $shippingCharge;
        return view('admin.shipping.edit', $data);
     
    }

    public function update($id, Request $request){

        $validator = Validator::make($request->all(), [
            'country' => 'required',
            'amount'  => 'required|numeric'
        ]);

        if($validator->passes()){

            
            $shippingCharge = ShippingCharge::find($id);
            
            if($shippingCharge == null){
                $request->session()->flash('error', 'Record Not Found');
                return response()->json([
                    'status' => true,
                    'message' => 'Recourd Not Found'
                ]); 
            }
            
            
          
            $shippingCharge->country_id = $request->country;
            $shippingCharge->amount = $request->amount;
            $shippingCharge->save();

            $request->session()->flash('success', 'Shipping Charge updated successfully');
            return response()->json([
                'status' => true,
                'message' => 'Shipping Charge updated successfully'
            ]);

        }else{

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function  destroy($id, Request $request){

        $shippingCharge = ShippingCharge::find($id);

        if($shippingCharge == null){
           $request->session()->flash('error', 'Record Not Found');
           return response()->json([
            'status' => false,
            'message' => "Record Not Found"
        ]);

        }

       $shippingCharge->delete();
       $request->session()->flash('success', 'Record Deleted Successfully');
        return response()->json([
            'status' => true,
            'message' => "Record Deleted Successfully"
        ]);

    }

    
}
