<?php

namespace App\Http\Controllers;
use App\Http\Resources\SliderCollection;
use App\Http\Resources\BannerCollection;
use App\Http\Resources\SliderResource;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\SubcategoryCollection;
use App\Http\Resources\SubcategoryResource;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductCollection;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Product;
use App\Models\Banner;
use App\Models\Subcategory;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    public function data()
    {
        $sliders = Slider::all();
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $banners = Banner::orderBy('order', 'ASC')->get();

        return response([
            'sliders' => new SliderCollection($sliders),
            'banners' => new BannerCollection($banners),
            
            'categories' => new CategoryCollection($categories),
            

        ], 201);
    }
    public function homepage_products() {
        $featured = Product::take(12)->orderBy('created_at', 'ASC')->get();
        $products = Product::take(12)->get();
        $best_selling =  Product::withCount('order')->orderBy('order_count', 'desc')->get();
        return response([
            'products' => new ProductCollection($products),
            'featured' => new ProductCollection($featured),
            'best_selling' => new ProductCollection($best_selling),
            


        ], 201);
        
    }
    public function related(Product $product) {

        $products = Product::whereHas('category', function($query) use($product) 
        { 
            $query->where('category_id', $product->category_id); 
        })->get();
        return new ProductCollection($products);
        
    }

    public function browse($category = null, $subcategory = null) {
        $selectedCategories = null;
        $selectedSubcategories = null;
        if (request('sortby') == 0) {
            $sort_field = 'created_at';
            $sort_direction = 'DESC';
        }
        elseif(request('sortby') == 1) {
            $sort_field = 'sale_price';
            $sort_direction = 'ASC';
        }
        elseif (request('sortby') == 2) {
            $sort_field = 'sale_price';
            $sort_direction = "DESC";
        }
        elseif(request('sortby') == 3) {
            $sort_field = 'order_count';
            $sort_direction = "DESC";
        }
       

        if(request('selectedCategories') == '' && request('selectedSubcategories') == '') {

            $products = Product::withCount('order')->orderBy($sort_field, $sort_direction)->when($category, function ($query, $category) {
                $query->where('category_id', $category);
            })->when($subcategory, function ($query, $subcategory) {
                $query->where('subcategory_id', $subcategory);
            })->paginate(9);

        }
        else {
            
       $selectedCategories = explode(',', request('selectedCategories'));
       $selectedSubcategories = explode(',', request('selectedSubcategories'));  
       $products = Product::withCount('order')->whereIn('category_id', $selectedCategories)
        ->orwhereIn('subcategory_id', $selectedSubcategories)->orderBy( $sort_field, $sort_direction)->paginate(9);
}
        return new ProductCollection($products);
        
    }
    public function browseByCategory($category) {
        if (request('sortby') == 0) {
            $sort_field = 'created_at';
            $sort_direction = 'DESC';
        }
        elseif(request('sortby') == 1) {
            $sort_field = 'sale_price';
            $sort_direction = 'ASC';
        }
        elseif (request('sortby') == 2) {
            $sort_field = 'sale_price';
            $sort_direction = "DESC";
        }
        elseif(request('sortby') == 3) {
            $sort_field = 'order_count';
            $sort_direction = "DESC";
        }
        if(request('selectedSubcategories') == '') {
            $products = Product::withCount('order')->orderBy($sort_field, $sort_direction)->where('category_id', $category)->get();
        }else {
            $selectedSubcategories = explode(',', request('selectedSubcategories'));  
            $products = Product::withCount('order')->whereIn('subcategory_id', $selectedSubcategories)->orderBy( $sort_field, $sort_direction)->paginate(9);
        }
        $subcategories = Subcategory::where('category_id', $category)->get();
        
        return (new ProductCollection($products))->additional([
            'subcategories' => new SubcategoryCollection($subcategories),
            
        ]);

    }
    public function browseBySubcategory($subcategory) {
        if (request('sortby') == 0) {
            $sort_field = 'created_at';
            $sort_direction = 'DESC';
        }
        elseif(request('sortby') == 1) {
            $sort_field = 'sale_price';
            $sort_direction = 'ASC';
        }
        elseif (request('sortby') == 2) {
            $sort_field = 'sale_price';
            $sort_direction = "DESC";
        }
        elseif(request('sortby') == 3) {
            $sort_field = 'order_count';
            $sort_direction = "DESC";
        }
        $products = Product::withCount('order')->where('subcategory_id', $subcategory)->paginate(9);
        return new ProductCollection($products);

    }
    public function categories()
    {
        $categories = Category::take(8)->get();
        return response([
            
            'categories' => new CategoryCollection($categories),

        ], 201);
    }
    public function subcategories()
    {
        
        $subcategories = Subcategory::take(8)->get();
        return response([
            
            'subcategories' => new SubcategoryCollection($subcategories),

        ], 201);
    }

    public function search() {
        if(request('searching')) {
            $searching = request('searching');
            $products = Product::where('name', 'LIKE', '%' . $searching . '%' )->take(5)->get();

        }
        
        return response([
           
            'products' => new ProductCollection($products),
            


        ], 201);

    }
   
}
