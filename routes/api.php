<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::get('/email/verify/{id}', 'VerificationController@verify')->name('verification.verify');
    Route::get('/email/resend', 'VerificationController@resend')->name('verification.resend');

    Route::apiResource('/products', 'ProductController');
    route::get('/show/data', 'HomeController@data');
    route::get('/show/home', 'HomeController@homepage_products');
    route::get('/show/related/{product}', 'HomeController@related');

    route::get('/search/products', 'HomeController@search');
    Route::get('browse/categories', 'HomeController@categories');
    Route::get('browse/subcategories', 'HomeController@subcategories');
    route::get('/browse', 'HomeController@browse');
    
    route::get('/browse/{category}', 'HomeController@browseByCategory');
    route::get('/browse/subcategory/{subcategory}', 'HomeController@browseBySubcategory');

    Route::post('/logout', 'UserController@logout')->middleware('auth:sanctum')->name('logout');

    


    Route::apiResource('/attributes', 'AttributeController');
    Route::apiResource('/sliders', 'SliderController');
    Route::apiResource('/banners', 'BannerController');
 

    Route::apiResource('/subcategories', 'SubcategoryController');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
   
    Route::get('/orders', 'OrderController@index');
    Route::get('/orders/{order}', 'OrderController@show');
    Route::post('/orders', 'OrderController@store');
    Route::get('/profile', 'UserController@profile');
 
  
    


    });
    Route::get('/settings', 'SettingsController@index');

Route::group(['middleware' => ['admin']], function () {
    route::get('/analytics', 'AnalyticsController@analytics');
    route::get('/dashbord/analytics', 'AnalyticsController@dashbord');
    route::get('/dashbord/notifications', 'AnalyticsController@notifications');
    route::get('/admin/data', 'AnalyticsController@data');

    Route::put('/up/banners/{banner}', 'BannerController@goUp');
    Route::put('/down/banners/{banner}', 'BannerController@goDown');
    Route::get('/users','Admin\UsersController@index');
    Route::delete('/delete/gallery/{gallery}', 'ProductController@removeImage');
    Route::post('/settings', 'SettingsController@store');
    Route::apiResource('/categories', 'CategoryController');
    Route::apiResource('/subcategories', 'SubcategoryController');
    Route::get('/subcategories/category/{id}', 'SubcategoryController@category');
    Route::get('/admin/orders', 'Admin\OrdersController@index');
    Route::get('/admin/orders/{order}', 'Admin\OrdersController@show');

    Route::put('/admin/orders/{order}', 'Admin\OrdersController@update');



  
    


    });

Route::post('/register', 'UserController@register')->name('register');
Route::post('/login', 'UserController@login')->name('login');

