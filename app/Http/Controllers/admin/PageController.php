<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Page;

class PageController extends Controller
{
   public function index(Request $request){

        $pages = Page::latest();

        // Check if a keyword is provided and adjust the query
        if (!empty($request->get('keyword'))) {
        $keyword = $request->get('keyword');
        $pages = $pages->where('name', 'like', '%' . $keyword . '%');
    }

        // Paginate the results
        $pages = $pages->paginate(10);

    // Return the view with the pages
        return view('admin.pages.list', compact('pages'));
   }



   public function create(){

    return view('admin.pages.create');
   } 

   public function store(Request $request){

    $validator = Validator::make($request->all(), [
        'name' => 'required|min:3|max:255',
        'slug' => 'required|unique:pages', 
    ]);

    if($validator->passes()){
         $page = new Page();

         $page->name = $request->name;
         $page->slug = $request->slug;
         $page->content = $request->content;
         $page->save();

         session()->flash('success',  $request->name.'Page created successfully');
         return response()->json([
            'status' => true,
            'errors' =>  $request->name.'Page created successfully'
        ]);

   }else{
    return response()->json([
        'status' => false,
        'errors' =>  $validator->errors()
    ]);
   }
   }



  //edit mathod
   public function edit($id)
   {
       $page = Page::find($id);
   
       if (!$page) {
           session()->flash('error', 'Page not found.');
           return redirect()->route('pages.index');
       }
   
       return view('admin.pages.edit', compact('page'));
   }
   


   //update method

   public function update(Request $request, $id)
   {
       $page = Page::find($id);
   
       if (!$page) {
           return response()->json(['status' => false, 'error' => 'Page not found.']);
       }
   
       $validator = Validator::make($request->all(), [
           'name' => 'required|string|max:255',
           'slug' => 'required|string|max:255|unique:pages,slug,' . $page->id,
           'content' => 'required|string',
       ]);
   
       if ($validator->fails()) {
           return response()->json(['status' => false, 'errors' => $validator->errors()]);
       }
   
       $page->update([
           'name' => $request->name,
           'slug' => $request->slug,
           'content' => $request->content,
       ]);
   
       session()->flash('success',  $request->name.' Page are updated successfully.');
       return response()->json(['status' => true, 'message' =>  $request->name.' Page updated successfully.']);
   }




   //delete method
   public function destroy($id)
{
    $page = Page::find($id);

    if (!$page) {
        session()->flash('success',  'Page already deleted successfully.');
        return response()->json(['status' => false, 'message' => 'Page not found.']);
    }

    $page->delete();
    session()->flash('success',  'Page deleted successfully.');
    return response()->json(['status' => true, 'message' => 'Page deleted successfully.']);
}



}
