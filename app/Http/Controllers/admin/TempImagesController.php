<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TempImagesController extends Controller
{
    public function create(Request $request)
    {
       
        $image = $request->file('image'); // Correctly accessing the uploaded file
        if (!empty($image)) {
            
            $tempImage = new TempImage();
            // dd($tempImage->all());
            $ext = $image->getClientOriginalExtension();
            
            $newName = time().'.'.$ext;
            $tempImage->name = $newName;
            $tempImage->save();
            
            $image->move(public_path('/temp'), $newName);
            
            //Generate thumnail
            $sPath = public_path().'/temp/'.$newName;
            $dPath = public_path().'/temp/thumbnail/'.$newName;
            
            // Ensure the destination directory exists
            if (!file_exists(public_path('/temp/thumbnail'))) {
                mkdir(public_path('/temp/thumbnail'), 0777, true);
             
            }

            $manager = new ImageManager(Driver::class);
            $img = $manager->read($sPath);

            // crop the best fitting 5:3 (600x360) ratio and resize to 600x360 pixel
            $img->resize(300, 300);
            $img->save($dPath);

           
           

            return response()->json([
                'status' => true,
                'image_id' => $tempImage->id,
                'imagePath' => asset('/temp/thumbnail/'.$newName) ,
                'message' => "Image upload successful"
            ]);
        }

        // Return an error response if no file was uploaded
        return response()->json(['error' => 'No file uploaded'], 400); 
    }
}
