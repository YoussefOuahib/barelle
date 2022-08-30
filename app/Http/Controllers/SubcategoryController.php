<?php

namespace App\Http\Controllers;

/*Requests */
use Illuminate\Http\Request;

/*Resources & Collections */
use App\Http\Resources\SubcategoryCollection;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\SubcategoryResource;
/* Models */ 
use App\Models\Category;
use App\Models\Subcategory;


class SubcategoryController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories = Subcategory::paginate(10);
        $categories = Category::all();

        return (new SubcategoryCollection($subcategories))->additional([
            'categories' => new CategoryCollection($categories),
            
        ]);
    }
    public function category($id) {
        $subcategories = Subcategory::where('category_id', $id)->get();

        return response([
            'subcategories' => $subcategories,
        ], 201);
    }

  
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subcategory = Subcategory::create([
            'name' => $request->name,
            'category_id' => $request->category_id
            
        ]);
        return (new SubcategoryResource($subcategory))->additional([
            'status' => 201
        ]);
    }
   
    
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Subcategory $subcategory)
    {
        
        return new SubcategoryResource($subcategory);
    }

  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Subcategory $subcategory)
    {
        $subcategory->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
        ]);
        return response()->json(['status' => 201]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subcategory $subcategory)
    {       
        $subcategory->delete();
        return response()->json(['status' => 201]);
        
    }
}
