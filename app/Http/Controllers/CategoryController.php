<?php

namespace App\Http\Controllers;

/*Traits */
use App\Traits\UploadTrait;

/*Requests */
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

/*Collection & Resources */
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;

/* Models */
use App\Models\Category;

/* Helpers */
use Image;
use Carbon\Carbon;

class CategoryController extends Controller
{
    use UploadTrait;
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

   
    public function store(StoreCategoryRequest $request)
    {
        $imageName = $this->upload($request);
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
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {

        if ($request->file('image')) {
            $imageName = $this->upload($request);
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
        if ($category->subcategories->count() == 0) {
            $category->delete();
            $this->deleteimage($category->image);
            return response()->json(['status' => 201]);
        } else {
            return response()->json(['status' => 403]);
        }
    }
}
