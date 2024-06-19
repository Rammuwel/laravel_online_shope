<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Models\SubCategory;
use App\Models\Category;



class SubCategoryController extends Controller
{
    public function index(Request $request){
        $subCategories = SubCategory::latest('id')->select('sub_categories.*', 'categories.name as categoryName')->leftJoin('categories', 'categories.id', 'sub_categories.category_id');

       // Check if a keyword is provided and adjust the query
       if (!empty($request->get('keyword'))) {
        $keyword = $request->get('keyword');
        $subCategories = $subCategories->where('sub_categories.name', 'like', '%' . $keyword . '%');
        $subCategories = $subCategories->orWhere('categories.name', 'like', '%' . $keyword . '%');
      }

       // Paginate the results
       $subCategories = $subCategories->paginate(10);

      // Return the view with the categories
       return view('admin.sub_category.list', compact('subCategories'));
    }
    


    public function create(){
        
        $categories = Category::orderBy('id', 'ASC')->get();
        $data['categories'] = $categories;
        return view('admin.sub_category.create', $data);
    }



    public function store(Request $request){
       
        $validator = Validator::make($request->all(), [
           'name' => 'required',
           'slug' => 'required|unique:sub_categories',
           'status' => 'required',
           'category' => 'required'
        ]);

        if ($validator->passes()) {
             
            $subCategory = new SubCategory();

            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->status = $request->status;
            $subCategory->showHome = $request->showHome;
            $subCategory->category_id = $request->category;
            $subCategory->save();




            $request->session()->flash('success', 'Sub category created successfully');

            return response()->json([
               'status' => true,
               'message' => ' Sub Cetegory created successfully',
            ]);
            
        } else {
            return response([
               'status' => false,
               'error' => $validator->errors()

            ]);
        }
        
    }



    public function edit($subCategoryId, Request $request){

        $subCategory = SubCategory::find($subCategoryId);

        if(empty($subCategory)){
           $request->session()->flash('error', ' Record not found');
            return redirect()->Route('sub-categories.index');
        }
       
        $categories = Category::orderBy('id', 'ASC')->get();
        $data['categories'] = $categories;
        $data['subCategory'] = $subCategory;
        return view('admin.sub_category.edit', $data);

    }



    public function update($subCategoryId, Request $request){
           
          
        $subCategory = SubCategory::find($subCategoryId);

        if(empty($subCategory)){
           $request->session()->flash('error', ' Record not found');
            // return redirect()->Route('sub-categories.index');
            return response()->json([
              'status' => false,
              'notFound' => true
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:sub_categories,slug,'.$subCategory->id,
            'status' => 'required',
            'category' => 'required'
         ]);
 
         if ($validator->passes()) {

             $subCategory->name = $request->name;
             $subCategory->slug = $request->slug;
             $subCategory->status = $request->status;
             $subCategory->showHome = $request->showHome;
             $subCategory->category_id = $request->category;
             $subCategory->save();
 
 
 
 
             $request->session()->flash('success', 'Sub category uddated successfully');
 
             return response()->json([
                'status' => true,
                'message' => ' Sub Cetegory updated successfully',
             ]);
             
         } else {
             return response([
                'status' => false,
                'error' => $validator->errors()
 
             ]);
         }
    }


    
    public function destroy($subCategoryId, Request $request){
         
        $subCategory = SubCategory::find($subCategoryId);
       
        if(empty($subCategory)){
            
           $request->session()->flash('error', 'Record not found');
            
            return response()->json([
              'status' => false,
              'notFound' => true
            ]);
        }

        $subCategory->delete();

        $request->session()->flash('success', 'sub category deleted successfully');
           
         return response()->json([
            'status' => true,
            'message' => 'sub category deleted successfully'
         ]);

    }

}
