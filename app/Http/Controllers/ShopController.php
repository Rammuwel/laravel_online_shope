<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\ProductRatting;

use App\Models\Product;
use Validator;

class ShopController extends Controller
{
    public function index(Request $request, $categorySlug = null, $subCategorySlug = null){

        $categorySelected = "";
        $subCategorySelected = "";
        $priceMin = 0;
        $priceMax = 10000;
        $brandArray = [];
        
      

        
        $categories = Category::orderBy('name', 'ASC')
        ->where('status', 1)
        ->with(['sub_category' => function($query) {
            $query->where('status', 1)
                  ->where('showHome', 'Yes')
                  ->orderBy('id', 'DESC');
        }])
        ->get();
        $brands = Brand::orderBy('id', 'ASC')->where('status', 1)->get();

        $products = Product::where('status', 1);

        // Apply filter here
        if(!empty($categorySlug)){
           $category = Category::where('slug', $categorySlug)->first();
           $products = $products->where('category_id', $category->id);
           $categorySelected = $category->id;
        }

        if(!empty($subCategorySlug)){
           $subCategory = SubCategory::where('slug', $subCategorySlug)->first();
           $products = $products->where('sub_category_id', $subCategory->id);
           $subCategorySelected = $subCategory->id;
        }

        if(!empty($request->get('brand'))){
            
            $brandArray = explode(',',$request->get('brand'));
            $products = $products->whereIn('brand_id', $brandArray);
        } 
      
        if(!empty($request->get('price_min')) != null && $request->get('price_max') != null) {
            $priceMin = intval($request->get('price_min'));
            $priceMax = intval($request->get('price_max'));

            if($priceMax > 10000){
                $products =  $products->whereBetween('price', [$priceMin, 1000000]);  
            }else{
                $products =  $products->whereBetween('price', [$priceMin, $priceMax]); 
            }
            
        }

        if(!empty($request->get('search'))){
            $products = $products->where('title', 'like', '%'.$request->get('search').'%');  
        }


        if($request->get('sort') != null){
            if($request->get('sort') == "latest"){
                $products =  $products->orderBy('id', 'DESC');

            }elseif ($request->get('sort') == "sort_asc") {
                $products =  $products->orderBy('price', 'ASC');
            }else{
                $products =  $products->orderBy('price', 'DESC');
            }
        }
        else{

            $products =  $products->orderBy('id', 'DESC');
        }


       

       
        $products =  $products->paginate(9);


        $data['categories'] = $categories;
        $data['brands'] = $brands;
        $data['products'] = $products;
        $data['categorySelected'] = $categorySelected;
        $data['subCategorySelected'] = $subCategorySelected;
        $data['brandArray'] = $brandArray;
        $data['priceMin'] =  $priceMin;
        $data['priceMax'] =  $priceMax;
        $data['sort'] =  $request->get('sort');

        return view('front.shop', $data);
    }


   public function product($slug, Request $request){

    $relatedProducts = [];

    $product = Product::where('slug', $slug)->with('product_images')->first();
    // dd($product);
    if($product == null){
        abort(404);
    }

      // fachind related product
      if ($product->related_products != '') {
        
        $productArray = explode(',', $product->related_products);
        $relatedProducts =  Product::whereIn('id', $productArray)->with('product_images')->get();
        // dd($relatedProducts);
     }

    $data['product'] = $product;
    $data['relatedProducts'] = $relatedProducts;
    return view('front.product', $data);

   }


  public function saveRattings($productId, Request $request){
   
    $validator = Validator::make($request->all(), [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'ratting' => 'required',
        'review'  => 'required'
    ]);

    if($validator->passes()){

        $productRatting = new ProductRatting();
        $productRatting->product_id = $productId;
        $productRatting->username = $request->name;
        $productRatting->email = $request->email;
        $productRatting->ratting = $request->ratting;
        $productRatting->comment = $request->review;
        $productRatting->save();


        session()->flash('Your review successfully recieved');
        return response()->json([
            'status' => true,
            'message' => 'Your review successfully recieved',
        ]);
        

    }else{
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
    }
  }

}
