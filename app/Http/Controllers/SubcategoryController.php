<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Resources\SubcategoryCollection;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\SubcategoryResource;

class SubcategoryController extends Controller
{
    public function __construct() {
        $this->middleware('auth:sanctum')->except(['index','show']);
      }
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categories = Category::all();
        if($categories){
        $subcategory = Subcategory::create([
            'name' => $request->name,
            'category_id' => $request->category_id
            
        ]);
        return (new SubcategoryResource($subcategory))->additional([
            'status' => 201
        ]);
    }
    else {
        return response()->json(['message' => 'You must add category first']);
    }
    
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
