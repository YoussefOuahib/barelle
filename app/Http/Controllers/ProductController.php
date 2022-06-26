<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\AttributeCollection;
use App\Http\Resources\AttributeValueCollection;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SubcategoryCollection;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image;

class ProductController extends Controller
{
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
        } elseif (request('filterBy') == 1) {
            $sort_field = 'created_at';
            $sort_direction = 'ASC';
        } elseif (request('filterBy') == 2) {

            $products = Product::withCount('order')->orderBy('order_count', 'desc')
                ->where('name', 'LIKE', '%' . $search . '%')
                ->when($category, function ($query, $category) {
                    $query->where('category_id', $category);
                })->paginate(10);
        } elseif (request('filterBy') == 3) {
            $sort_field = 'sale_price';
            $sort_direction = 'ASC';
        } elseif (request('filterBy') == 4) {
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
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $imageName = Carbon::now()->timestamp . '.' . $request->image->extension();
        $location = public_path('storage/products/' . $imageName);
        Image::make($request->image)->resize(600, 600)->save($location);

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
            $imgsName = "";
            foreach ($request->gallery as $key => $image) {
                $imgName = Carbon::now()->timestamp . $key . '.' . $image->extension();

                $location = public_path('storage/products/' . $imgName);
                Image::make($image)->resize(600, 600)->save($location);

                if ($key == 0) {
                    $imgsName = $imgName;
                }
                $gallery = Gallery::create([
                    'product_id' => $product->id,
                    'image' => $imgName,
                ]);
            }
        }

        if ($request->attrs) {
            $attrs = explode(',', $request->attrs);
            $values = json_decode($request->values);
            $prices = json_decode($request->prices);

            foreach ($attrs as $key => $myattr) {

                $prod_attr = Attribute::where('name', $myattr)->first()->id;

                foreach ($values[$key] as $k => $value) {

                    $attribute = AttributeValue::create([
                        'product_id' => $product->id,
                        'attribute_id' => $prod_attr,
                        'value' => $value,
                        'price_variation' => $prices[$key][$k],

                    ]);
                }
            }
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $imageName = $product->image;
        $path = public_path() . '/storage/products';

        if ($request->file('image')) {
            $imageName = Carbon::now()->timestamp . '.' . $request->image->extension();
            $location = public_path('storage/products/' . $imageName);
            Image::make($request->image)->resize(600, 600)->save($location);

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
            $imgsName = "";
            foreach ($request->gallery as $key => $image) {
                $imgName = Carbon::now()->timestamp . $key . '.' . $image->extension();

                $location = public_path('storage/products/' . $imgName);
                Image::make($image)->resize(600, 600)->save($location);


                if ($key == 0) {
                    $imgsName = $imgName;
                }
                $gallery = Gallery::create([
                    'product_id' => $product->id,
                    'image' => $imgName,
                ]);
            }
        }

        if ($request->attrs) {
            $attrs = explode(',', $request->attrs);
            $values = json_decode($request->values);
            $prices = json_decode($request->prices);
            $attribute = AttributeValue::where('product_id', $product->id)->delete();

            foreach ($attrs as $key => $myattr) {

                $prod_attr = Attribute::where('name', $myattr)->first()->id;
                foreach ($values[$key] as $k => $value) {

                    AttributeValue::create([
                        'product_id' => $product->id,
                        'attribute_id' => $prod_attr,
                        'value' => $value,
                        'price_variation' => $prices[$key][$k],
                    ]);
                }
            }
        }

        return response()->json(['status' => 201]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {

        $attrs = AttributeValue::where('product_id', $product->id)->get();
        $gallery = Gallery::where('product_id', $product->id)->get();
        $product->delete();
        $product->forcedelete();
        $product->deleteimage();
        if ($attrs) {
            foreach ($attrs as $attr) {
                $attr->delete();
            }
        }
        if ($gallery) {
            foreach ($gallery as $img) {
                $img->delete();
            }
        }
        return response()->json(['status' => 201]);
    }
    public function removeImage($id)
    {
        $gallery = Gallery::find($id);
        $gallery->delete();
        return response()->json(['status' => 201]);
    }
}
