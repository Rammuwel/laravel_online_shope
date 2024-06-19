<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductImage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;

class productImageController extends Controller
{
    public function upload(Request $request){
         

        $image = $request->image;

        $ext = $image->getClientOriginalExtension();   
        $sPath = $image->getPathName();
       
       

        $productImage = new ProductImage(); 
        $productImage->product_id = $request->product_id;
        $productImage->image = 'NULL';
        $productImage->save();


        $imageName = $request->product_id.'-'.$productImage->id.'-'.time().'.'.$ext;
        $productImage->image = $imageName;
        $productImage->save();


       
        $dPath = public_path().'/upload/product/large/'.$imageName;
        // large image
        $manager = new ImageManager(Driver::class);
        $img = $manager->read($sPath);

        $img->resize(1400, null, function($constraint){
            $constraint->aspectRatio();
        });
        $img->save($dPath);

        // small image
        
        $sdPath = public_path().'/upload/product/small/'.$imageName;
        $manager = new ImageManager(Driver::class);
        $img = $manager->read($sPath);
        $img->resize(300, 300);
        $img->save($sdPath);

        return response()->json([
           'status' => true,
           'image_id' => $productImage->id,
           'image_path' => asset('upload/product/small/'.$imageName),
           'message' => 'image saved succrssfully' 
        ]);

    }

    public function destroy(Request $request){

            $productImage = ProductImage::find($request->id);

            if(empty($productImage)){
                
                return response()->json([
                    'status' => false,
                    'message' => 'Image not Found'
                ]);
            }

            // delete image from forlder

            File::delete(public_path('upload/product/small/'.$productImage->image));
            File::delete(public_path('upload/product/large/'.$productImage->image));

            $productImage->delete();

            return response()->json([
                 'status' => true,
                 'message' => 'Image deleted successfully'
            ]);

        

    }
}
