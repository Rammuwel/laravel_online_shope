<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    

    public function index(Request $request){
        $users = Auth::user();
        // $orders = Order::orderBy('orders.created_at', 'DESC')->select('orders.*', 'users.name', 'users.email');
        // $orders =  $orders->leftJoin('users', 'users.id', 'orders.user_id');
        
      
        // if($request->get('key') != ""){
        //     $orders = $orders->where('users.name', 'like', '%'.$request->keyword.'%');
            
        //     $orders = $orders->orWhere('users.emial', 'like', '%'.$request->keyword.'%');
            
        //     $orders = $orders->orWhere('orders.id', 'like', '%'.$request->keyword.'%');
        // }
        
        $orders = Order::orderBy('orders.created_at', 'DESC');

        if ($request->get('keyword') != "") {
            $keyword = $request->get('keyword');
            $keywords = explode(' ', $keyword);
    
            $orders = $orders->where(function($query) use ($keywords) {
                foreach ($keywords as $word) {
                    $query->orWhere('first_name', 'like', '%' . $word . '%')
                          ->orWhere('last_name', 'like', '%' . $word . '%')
                          ->orWhere('id', 'like', '%' . $word . '%')
                          ->orWhere('email', 'like', '%' . $word . '%')
                          ->orWhere('user_id', 'like', '%' . $word . '%');
                }
            });
        }

        $orders = $orders->paginate(10);

        // dd($orders);

        return view('admin.orders.list',['orders'=>$orders]);
    }

    public function details($id){

        // Retrieve the order along with the country name
        $order = Order::select('orders.*', 'countries.name as country_name')
                 ->leftJoin('countries', 'countries.id', '=', 'orders.country_id')
                 ->where('orders.id', $id)
                 ->first();

        // Check if the order exists
        if (!$order) {
            abort(404, 'Order not found');
        }

        $orderItem = OrderItem::where('order_id', $id)->get();

        return view('admin.orders.details', [
            'order' => $order,
            'orderItem' => $orderItem
            ]) ;
    }

    public function changeOrderStatus(Request $request, $orderId){
      
        $order = Order::find($orderId);

        if(empty($order)){

            session()->flash('error', 'Oreder Not Found');
            return response()->json([
                'status' => false,
                'message' => 'Oreder Not Found'
            ]);
        }

        $order->status = $request->status;
        $order->shipped_at = $request->shipped_at;
        $order->save();

        session()->flash('success', 'Order Status update successfuly.');
        return response()->json([
            'status' => true,
            'message' => 'Order Status update successfuly.'
        ]);

    }

    public function senInvoiceEmail(Request $request, $orderId){

        $order = Order::where('id', $orderId)->first();

        // dd($order);

        if(empty($order)){
          session()->flash('error', 'Order Not Found.');
          
          return response()->json([
             'status' => true,
             'message' => 'Order Not Fount.'
          ]);
        }

        if($request->userType == 'customer'){
            $message = 'Email sended to Customer.';
        }else {
            $message = 'Email sended to Admin.';
        }
         
        orderEmail($orderId, $request->userType);

        session()->flash('success', $message);
        return response()->json([
            'statis' => true,
            'message' =>  $message
        ]);
    }
}
