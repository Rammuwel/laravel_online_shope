<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\TempImage;
use App\Models\SubCategory;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{

    public function index(Request $request){
        $products = Product::latest('id')->with('product_images');
         
        if($request->get('keyword') != ""){
           $products = $products->where('title', 'like', '%'.$request->keyword.'%');
        }

        $products =  $products->paginate(10);
        $data['products'] = $products;
        return view('admin.products.list', $data);
    }



    public function create(Request $request){
        $data = [];
        $categories = Category::orderBy('name', 'ASC')->get();
        $brands = Brand::orderBy('name', 'ASC')->get();
        $data['categories'] = $categories;
        $data['brands'] = $brands;
        return view('admin.products.create', $data);
    }

    public function store(Request $request){

        // dd($request->image_array);

        // exit();

        $rules = [
             'title' => 'required',
             'slug' => 'required|unique:products',
             'price'  => 'required|numeric',
             'sku'  => 'required|unique:products',
             'track_qty' => 'required|in:Yes,No',
             'category'  => 'required|numeric',
             'is_featured' => 'required|in:Yes,No',
        ];
    
        if(!empty($request->track_qty) && $request->track_qty == 'Yes'){
            $rules['qty'] = 'required|numeric';
        }
        
        $validator = Validator::make($request->all(),$rules);


        if ($validator->passes()) {

            

             $product = new Product();
              
             $product->title = $request->title;
             $product->slug = $request->slug;
             $product->description = $request->description;
             $product->short_description = $request->short_description;
             $product->shipping_returns = $request->shipping_returns;
             $product->price = $request->price;
             $product->compare_price = $request->compare_price;
             $product->category_id = $request->category;
             $product->sub_category_id = $request->sub_category;
             $product->brand_id = $request->brand;
             $product->is_featured = $request->is_featured;
             $product->sku = $request->sku;
             $product->barcode = $request->barcode;
             $product->track_qty = $request->track_qty;
             $product->qty = $request->qty;
             $product->status = $request->status;
             $product->related_products = (!empty($request->related_products))?implode(',' , $request->related_products):'';
             
              
             $product->save();

             if(!empty($request->image_array)){

                foreach ($request->image_array as $temp_image_id) {

                    $tempImageInfo = TempImage::find($temp_image_id);
                    $extArray = explode('.', $tempImageInfo->name); 
                    $ext = last($extArray);


                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                    $productImage->image = 'NULL';
                    $productImage->save();

                    $imageName = $product->id.'-'.$productImage->id.'-'.time().'.'.$ext;
                    $productImage->image = $imageName;
                    $productImage->save();


                    //large image

                    // generate thumpnail
                    $sPath = public_path().'/temp/'.$tempImageInfo->name;
                    $dPath = public_path().'/upload/product/large/'.$imageName;
                    
                    

                    // Ensure the destination directory exists
                    if (!file_exists(public_path().'/upload/product/large')) {
                        mkdir(public_path().'/upload/product/large', 0777, true);
                     
                    }
        
                    $manager = new ImageManager(Driver::class);
                    $img = $manager->read($sPath);
        
                    // crop the best fitting 5:3 (600x360) ratio and resize to 600x360 pixel
                    $img->resize(1400, null, function($constraint){
                        $constraint->aspectRatio();
                    });
                    $img->save($dPath);
                    

                    //smallimage
                    $sdPath = public_path().'/upload/product/small/'.$imageName;
                    
                    

                    // Ensure the destination directory exists
                    if (!file_exists(public_path().'/upload/product/small')) {
                        mkdir(public_path().'/upload/product/small', 0777, true);
                     
                    }
        
                    $manager = new ImageManager(Driver::class);
                    $img = $manager->read($sPath);
        
                    // crop the best fitting 5:3 (600x360) ratio and resize to 600x360 pixel
                    $img->resize(300, 300);
                    $img->save($sdPath);

                }
             }

            $request->session()->flash('success', 'Product added successfully');
            return response()->json([
                'status' => true,
                'message' => 'Product added successfully'
            ]);
           
        } else {

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
                
            ]);
        }
        

    }

     
    public function edit($productId, Request $request){



        $product = Product::find($productId);

        if (empty($product)) {
            return redirect()->route('products.index')->with('error', 'Product not Found');
        }

       

        $productImages =  ProductImage::where('product_id', $product->id)->get();
        $subCategories =  SubCategory::where('category_id', $product->category_id)->get();

         // fachind related product
         if ($product->related_products != '') {
            $productArray = explode(',', $product->related_products);
            $relatedProducts =  Product::whereIn('id', $productArray)->get();
            // dd($relatedProducts);
         }


        $data = [];
        $data['productImages'] = $productImages;
        $data['product'] = $product;
        $data['subCategories'] = $subCategories;
        $categories = Category::orderBy('name', 'ASC')->get();
        $brands = Brand::orderBy('name', 'ASC')->get();
        $data['categories'] = $categories;
        $data['brands'] = $brands;
        $data['relatedProducts'] = $relatedProducts;
        return view('admin.products.edit', $data);
    }


    public function update($productId, Request $request){

        $product = Product::find($productId);

        if(empty($product)){

            $request->session()->flash('error', ' Product Not Found');
            return response()->json([
                'statuts' =>  false,
                'notFound' => true,
                'message' => ' Product Not Found'

            ]);
        }
        

        
        // dd($request->image_array);

        // exit();

        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products,slug,'.$product->id,
            'price'  => 'required|numeric',
            'sku'  => 'required|unique:products,sku,'.$product->id,
            'track_qty' => 'required|in:Yes,No',
            'category'  => 'required|numeric',
            'is_featured' => 'required|in:Yes,No',
       ];
   
       if(!empty($request->track_qty) && $request->track_qty == 'Yes'){
           $rules['qty'] = 'required|numeric';
       }
       
       $validator = Validator::make($request->all(),$rules);


       if ($validator->passes()) {

             
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->short_description = $request->short_description;
             $product->shipping_returns = $request->shipping_returns;
            $product->price = $request->price;
            $product->compare_price = $request->compare_price;
            $product->category_id = $request->category;
            $product->sub_category_id = $request->sub_category;
            $product->brand_id = $request->brand;
            $product->is_featured = $request->is_featured;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->track_qty = $request->track_qty;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->related_products = (!empty($request->related_products))?implode(',' , $request->related_products):'';
             
            $product->save();

            // if(!empty($request->image_array)){

            //    foreach ($request->image_array as $temp_image_id) {

            //        $tempImageInfo = TempImage::find($temp_image_id);
            //        $extArray = explode('.', $tempImageInfo->name); 
            //        $ext = last($extArray);


            //        $productImage = new ProductImage();
            //        $productImage->product_id = $product->id;
            //        $productImage->image = 'NULL';
            //        $productImage->save();

            //        $imageName = $product->id.'-'.$productImage->id.'-'.time().'.'.$ext;
            //        $productImage->image = $imageName;
            //        $productImage->save();


            //        //large image

            //        // generate thumpnail
            //        $sPath = public_path().'/temp/'.$tempImageInfo->name;
            //        $dPath = public_path().'/upload/product/large/'.$imageName;
                   
                   

            //        // Ensure the destination directory exists
            //        if (!file_exists(public_path().'/upload/product/large')) {
            //            mkdir(public_path().'/upload/product/large', 0777, true);
                    
            //        }
       
            //        $manager = new ImageManager(Driver::class);
            //        $img = $manager->read($sPath);
       
            //        // crop the best fitting 5:3 (600x360) ratio and resize to 600x360 pixel
            //        $img->resize(1400, null, function($constraint){
            //            $constraint->aspectRatio();
            //        });
            //        $img->save($dPath);
                   

            //        //smallimage
            //        $sdPath = public_path().'/upload/product/small/'.$imageName;
                   
                   

            //        // Ensure the destination directory exists
            //        if (!file_exists(public_path().'/upload/product/small')) {
            //            mkdir(public_path().'/upload/product/small', 0777, true);
                    
            //        }
       
            //        $manager = new ImageManager(Driver::class);
            //        $img = $manager->read($sPath);
       
            //        // crop the best fitting 5:3 (600x360) ratio and resize to 600x360 pixel
            //        $img->resize(300, 300);
            //        $img->save($sdPath);

            //    }
            // }

           $request->session()->flash('success', 'Product Updated successfully');
           return response()->json([
               'status' => true,
               'message' => 'Product Updated successfully'
           ]);
          
       } else {

           return response()->json([
               'status' => false,
               'errors' => $validator->errors()
               
           ]);
       }


        
    }

    public function destroy($productId, Request $request){
        $product = Product::find($productId);

        if (empty($product)) {
            
            $request->session()->flash('error', ' Product not found');

            return response()->json([
               'status' => false,
               'message' => ' Product not found'
            ]);
        }

         // delete image from forlder
         $productImages =  ProductImage::where('product_id', $productId)->get();

         if (!empty($productImages)) {
            foreach ($productImages as $productImage) {
                
                File::delete(public_path('upload/product/small/'.$productImage->image));
                File::delete(public_path('upload/product/large/'.$productImage->image));
       
                $productImage->delete(); // or bellow
            }

            // ProductImage::where('product_id', $productId)->delete();
            

         }

         $product->delete();

         $request->session()->flash('success', ' Product deleted successfully');

         return response()->json([
              'status' => true,
              'message' => 'Product deleted successfully'
         ]);
    }






    public function getProduct(Request $request)
    {
        $tempProduct = []; // Initialize as an empty array

        if ($request->term != null) {
            $products = Product::where('title', 'like', '%' . $request->term . '%')->get();

            if ($products != null) {
                foreach ($products as $product) {
                    $tempProduct[] = ['id' => $product->id, 'text' => $product->title];
                }
            }
        }

        return response()->json([
            'tags' => $tempProduct,
            'status' => true
        ]);
    }


   

}
