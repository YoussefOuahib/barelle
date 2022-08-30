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

    
    Route::prefix('show')->group(function () {
        Route::get('/show/data', 'HomeController@data');
        Route::get('/show/product/{product}', 'HomeController@product');
        Route::get('/show/home', 'HomeController@homepage_products');
        Route::get('/show/related/{product}', 'HomeController@related');
    });

    Route::prefix('browse')->group(function () {
        Route::get('browse/categories', 'HomeController@categories');
        Route::get('browse/subcategories', 'HomeController@subcategories');
        Route::get('/browse', 'HomeController@browse');
        Route::get('/browse/{category}', 'HomeController@browseByCategory');
        Route::get('/browse/subcategory/{subcategory}', 'HomeController@browseBySubcategory');
    });
    Route::get('/email/verify/{id}', 'VerificationController@verify')->name('verification.verify');
    Route::get('/email/resend', 'VerificationController@resend')->name('verification.resend');
    Route::get('/settings', 'SettingsController@index');
    Route::get('/search/products', 'HomeController@search');

    /* Authentication Routes */

    Route::post('/logout', 'UserController@logout')->middleware('auth:sanctum')->name('logout');
    Route::post('/register', 'UserController@register')->name('register');
    Route::post('/login', 'UserController@login')->name('login');
    

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {

    Route::get('/orders', 'OrderController@index');
    Route::get('/orders/{order}', 'OrderController@show');
    Route::post('/orders', 'OrderController@store');
    Route::get('/profile', 'UserController@profile');
    });
    

Route::group(['middleware' => ['auth:sanctum','admin']], function () {
    Route::post('/settings', 'SettingsController@store');
    Route::apiResource('/categories', 'CategoryController');
    Route::apiResource('/subcategories', 'SubcategoryController');
    Route::apiResource('/attributes', 'AttributeController');
    Route::apiResource('/sliders', 'SliderController');
    Route::apiResource('/banners', 'BannerController');
    Route::apiResource('/products', 'ProductController');
    Route::prefix('admin')->group(function () {
        Route::get('/orders', 'Admin\OrdersController@index');
        Route::get('/orders/{order}', 'Admin\OrdersController@show');
        Route::put('/orders/{order}', 'Admin\OrdersController@update');
        Route::get('/data', 'AnalyticsController@data');

    });
    route::get('/analytics', 'AnalyticsController@analytics');
    route::get('/dashbord/analytics', 'AnalyticsController@dashbord');
    route::get('/dashbord/notifications', 'AnalyticsController@notifications');
    Route::put('/up/banners/{banner}', 'BannerController@goUp');
    Route::put('/down/banners/{banner}', 'BannerController@goDown');
    Route::get('/users','Admin\UsersController@index');
    Route::delete('/delete/gallery/{gallery}', 'ProductController@removeImage');
    Route::get('/subcategories/category/{id}', 'SubcategoryController@category');
    


    });


