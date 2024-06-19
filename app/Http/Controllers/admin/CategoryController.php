<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\TempImage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


// require './vendor/autoload.php';



class CategoryController extends Controller
{
     public function index(Request $request){
      // Start with the Category model query
        $categories = Category::latest();

       // Check if a keyword is provided and adjust the query
       if (!empty($request->get('keyword'))) {
        $keyword = $request->get('keyword');
        $categories = $categories->where('name', 'like', '%' . $keyword . '%');
      }

       // Paginate the results
       $categories = $categories->paginate(10);

      // Return the view with the categories
       return view('admin.category.list', compact('categories'));
    }


   public function create(){
       return view('admin.category.create');
   }

   public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:categories',
            'status' => 'required'
        ]);


        if($validator->passes()){
            // dd($request);
            $category = new Category();

            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->showHome = $request->showHome;
        
            $category->save();

            if(!empty($request->image_id)){
              $tempImage = TempImage::find($request->image_id);
              $extArray = explode('.',$tempImage->name);
              $ext = last($extArray);

              $newImageName = $category->id.'.'.$ext;
              
              $sPath = public_path().'/temp/'.$tempImage->name;
              $dPath = public_path().'/upload/category/'.$newImageName;
              File::copy($sPath, $dPath);
               
              // generate image thumnail
              $dPath = public_path().'/upload/category/thumb/'.$newImageName;
              // $img = new ImageManager(new Driver()); // create instance
            
              // $img->resize(450, 600); // resize image to fixed size
              // $img->save($dPath);

              // $category->image = $newImageName;
              // $category->save();
              // create new image instance (800 x 600)
                $manager = new ImageManager(Driver::class);
                $img = $manager->read($sPath);

                // crop the best fitting 5:3 (600x360) ratio and resize to 600x360 pixel
                $img->resize(300, 275);
                $img->save($dPath);

                // save categories
                $category->image = $newImageName;
                $category->save(); 


            }

            // $category->session()->flash('success','Cetegory added successfully' );
            $request->session()->flash('success', 'Category created successfully');

            return response()->json([
               'status' => true,
               'message' => 'Cetegory added successfully',
            ]);

        }
        else{
            return response()->json([
              'status' => false,
              'error'  => $validator->errors()
            ]);
        }
   }

   public function edit($categoryId, Request $request){
        // dd($categoryId);
        $category = Category::find($categoryId);

        if(empty($category)){
          
          $request->session()->flash('error', ' Record not found');
          return redirect()->route('categories.index');
        }
      
       return view('admin.category.edit', compact('category'));
   }

 


   public function update($categoryId, Request $request){

    $category = Category::findOrFail($categoryId);

    if(empty($categoryId)){

      $request->session()->flash('error', 'Category not found');

      return response()->json([
        'status' => false,
        'notFound' => true,
        'message' => 'category not found'
      ]);
    }
    
        
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'slug' => 'required|unique:categories,slug,'.$category->id,
      'status' => 'required',
  ]);


  if($validator->passes()){
      // dd($request);
      // $category = new Category();

      $category->name = $request->name;
      $category->slug = $request->slug;
      $category->status = $request->status;
      $category->showHome = $request->showHome;
  
      $category->save();

      $oldImage = $category->image;

      if(!empty($request->image_id)){
        $tempImage = TempImage::find($request->image_id);
        $extArray = explode('.',$tempImage->name);
        $ext = last($extArray);

        $newImageName = $category->id.'-'.time().'.'.$ext;
        
        $sPath = public_path().'/temp/'.$tempImage->name;
        $dPath = public_path().'/upload/category/'.$newImageName;
        File::copy($sPath, $dPath);
         
        // generate image thumnail
        $dPath = public_path().'/upload/category/thumb/'.$newImageName;
        // $img = new ImageManager(new Driver()); // create instance
      
        // $img->resize(450, 600); // resize image to fixed size
        // $img->save($dPath);

        // $category->image = $newImageName;
        // $category->save();
        // create new image instance (800 x 600)
          $manager = new ImageManager(Driver::class);
          $img = $manager->read($sPath);

          // crop the best fitting 5:3 (600x360) ratio and resize to 600x360 pixel
          $img->resize(300, 275);
          $img->save($dPath);

          // save categories
          $category->image = $newImageName;
          $category->save(); 

          // delete old image
          File::delete(public_path().'/upload/category/thumb/'.$oldImage);
          File::delete(public_path().'/upload/category/'.$oldImage);


      }

      // $category->session()->flash('success','Cetegory added successfully' );
      $request->session()->flash('success', 'Category updated successfully');
      return response()->json([
         'status' => true,
         'message' => 'Cetegory updated successfully',
      ]);

  }
  else{
      return response()->json([
        'status' => false,
        'error'  => $validator->errors()
      ]);
  } 

   }

  

   public function destroy($categoryId, Request $request){

           $category = Category::find($categoryId);

           if(empty($category)){
            // return redirect()->route('categories.index');
            $request->session()->flash('error', 'Category not found');

            return response()->json([
              'status' => true,
              'message' => 'Category not found'
            ]);
           }
          // delete old image
          File::delete(public_path().'/upload/category/thumb/'.$category->image);
          File::delete(public_path().'/upload/category/'.$category->image);

          //delete category
          $category->delete();
           
          $request->session()->flash('success', 'Category deleted successfully');

          return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully'
          ]);
   }
}