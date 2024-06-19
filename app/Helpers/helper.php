<?php
 use App\Models\Category;
 use App\Models\ProductImage;
 use App\Models\Order;
 use App\Models\Country;
 use App\Models\Page;
 use Illuminate\Support\Facades\Mail;
 use App\Mail\OrderEmail;

 function getCategory(){
    
    return Category::orderBy('name', 'ASC')
    ->where('status', 1)
    ->where('showHome', 'Yes')
    ->with(['sub_category' => function($query) {
        $query->where('status', 1)
              ->where('showHome', 'Yes')
              ->orderBy('id', 'DESC');
    }])
    ->get();
 }


 function grtProductImage($productId){
    return ProductImage::where('product_id', $productId)->first();
 }


 function orderEmail($orderId, $userType = 'customer')
 {
     $order = Order::where('id', $orderId)->with('items')->first();
 
     if (!$order) {
         // Handle case where order is not found
         throw new \Exception('Order not found');
     }
 
     $subject = $userType === 'admin' ? 'New order received' : 'Thanks for your order';
 
     $mailData = [
         'subject' => $subject,
         'order' => $order,
         'userType' => $userType
     ];
 
     $recipientEmail = $userType === 'admin' ? 'admin@example.com' : $order->email;
 
     Mail::to($recipientEmail)->send(new OrderEmail($mailData));
 }


 function getCountryInfo($countryId){
    return Country::where('id', $countryId)->first();
 }

 function getPages(){
    $pages = Page::all();
    return $pages;
 }



?>