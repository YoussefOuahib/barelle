<?php

namespace App\Http\Controllers;

/*Traits */
use App\Traits\UploadTrait;

/*Requests */
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

/*Collections & Resources */
use App\Http\Resources\AttributeCollection;
use App\Http\Resources\AttributeValueCollection;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\SubcategoryCollection;
use App\Http\Resources\ProductResource;

/*Models */
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Subcategory;

/*Services */
use App\Services\AttributeService;
use App\Services\GalleryService;

/*Helpers */
use Illuminate\Support\Str;
use Carbon\Carbon;
use Image;

class ProductController extends Controller
{
    use UploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');
        $category = request('showByCategory');
        if (request('filterBy') == 0) {
            $sort_field = 'created_at';
            $sort_direction = 'DESC';
        } 
        elseif (request('filterBy') == 1) {
            $sort_field = 'created_at';
            $sort_direction = 'ASC';
        } 
        elseif (request('filterBy') == 2) {
            $products = Product::withCount('order')
            ->orderBy('order_count', 'desc')
            ->where('name', 'LIKE', '%' . $search . '%')
            ->when($category, function ($query, $category) {
                $query->where('category_id', $category);
            })->paginate(10);
        } 
        elseif (request('filterBy') == 3) {
            $sort_field = 'sale_price';
            $sort_direction = 'ASC';
        }
         elseif (request('filterBy') == 4) {
            $sort_field = 'sale_price';
            $sort_direction = 'DESC';
        }
        if (request('filterBy') != 2) {
            $products = Product::orderBy($sort_field, $sort_direction)
                ->where('name', 'LIKE', '%' . $search . '%')
                ->when($category, function ($query, $category) {
                    $query->where('category_id', $category);
                })->paginate(10);
        }
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $attributes = Attribute::all();
        return (new ProductCollection($products))->additional([
            'categories' => new CategoryCollection($categories),
            'subcategories' => new SubcategoryCollection($subcategories),
            'attributes' => new AttributeCollection($attributes),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request, GalleryService $galleryService, AttributeService $attributeService)
    {

        $imageName = $this->upload($request);

        $product = Product::create([
            'category_id' => $request->category,
            'subcategory_id' => $request->subcategory,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'short_description' => $request->short_description,
            'description' => $request->description,
            'regular_price' => $request->regular_price,
            'sale_price' => $request->sale_price,
            'shipping_fee' => $request->shipping_fee,
            'image' => $imageName,
            'status' => $request->status,

        ]);

        if ($request->gallery) {
            $galleryService->store($request, $product->id);
        }

        if ($request->attrs) {
            $attributeService->store($request, $product->id);
        }

        return response([
            'product' => new ProductResource($product),

        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $attribute_value = AttributeValue::where('product_id', $product->id)->get();

        return response([
            'product' => new ProductResource($product),
            'attributes' => new AttributeValueCollection($attribute_value),

        ], 201);
    }

    /**
      * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, GalleryService $galleryService,  AttributeService $attributeService,  Product $product)
    {

        if ($request->file('image')) {
            $imageName = $this->upload($request);
        }
        $product->update([
            'category_id' => $request->category,
            'subcategory_id' => $request->subcategory,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'short_description' => $request->short_description,
            'description' => $request->description,
            'sale_price' => $request->sale_price,
            'regular_price' => $request->regular_price,
            'shipping_fee' => $request->shipping_fee,
            'status' => $request->status,
            'image' => $imageName,

        ]);

        if ($request->file('gallery')) {
            $galleryService->store($request, $id);
        }

        if ($request->attrs) {
            $attributeService->store($request, $id);
        }

        return response()->json(['status' => 201]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product , GalleryService $galleryService , AttributeService $attributeService)
    {
        $product->delete();
        $this->deleteimage($product->image);

        $galleryService->delete($product->id);
        $attributeService->delete($product->id);

        return response()->json(['status' => 201]);
    }
    public function removeImage($id)
    {
        $gallery = Gallery::find($id);
        $gallery->delete();
        Storage::delete('/images/' . $gallery);
        return response()->json(['status' => 201]);
    }
}
