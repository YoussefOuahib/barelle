<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use Image;
use Carbon\Carbon;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 
    public function index()
    {
        $categories = Category::paginate(10);
        return (new CategoryCollection($categories));
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
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $imageName = Carbon::now()->timestamp.'.'.$request->image->extension();
        /*
        $location = public_path('storage/products/' . $imageName);
        Image::make($request->image)->resize(600,600)->save($location);
*/
        $request->image->move(public_path('/storage/products'), $imageName);
        $category = Category::create([
            'name' => $request->name,
            'image' => $imageName,
        ]);
        return (new CategoryResource($category))->additional([
            'status' => 201
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
  
       
        if($request->file('image')){
        $imageName = Carbon::now()->timestamp.'.'. $request->image->extension();

        $request->image->move(public_path('products'), $imageName);
     
        }
        $category->update([
            'image' => $imageName,
            'name' => $request->name,
        ]);
        return response()->json(['status' => 201]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if($category->subcategories->count() == 0) {
        $category->delete();
        return response()->json(['status' => 201]);
        }else {
            return response()->json(['status' => 301]);

        }
    }
}
