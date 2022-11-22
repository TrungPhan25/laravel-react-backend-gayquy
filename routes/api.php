<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\BlogController;
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
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::middleware(['auth:sanctum','isAPIAdmin'])->group(function (){

    Route::get('/checkingAuthenticated',function (){
        return response()->json(['message'=>'You are in','status'=>200],200);
    });
    //Logout
    Route::post('/logout',[AuthController::class,'logout']);
    // Category
    Route::get('view-category',[CategoryController::class,'index']);

    Route::post('store-category',[CategoryController::class,'store']);
    Route::get('edit-category/{id}',[CategoryController::class,'edit']);
    Route::put('update-category/{id}',[CategoryController::class,'update']);
    Route::delete('delete-category/{id}',[CategoryController::class,'destroy']);
    Route::get('all-category',[CategoryController::class,'allCategory']);
    //Product
    Route::post('store-product',[ProductController::class,'store']);
    Route::get('view-product',[ProductController::class,'index']);
    Route::get('edit-product/{id}',[ProductController::class,'edit']);
    Route::post('update-product/{id}',[ProductController::class,'update']);
    //Slider
    Route::post('store-slider',[SliderController::class,'store']);
    Route::get('view-slider',[SliderController::class,'index']);
    Route::get('edit-slider/{id}',[SliderController::class,'edit']);
    Route::post('update-slider/{id}',[SliderController::class,'update']);
    //Order
    Route::get('view-order',[OrderController::class,'index']);
    Route::get('edit-order/{id}',[OrderController::class,'edit']);
    Route::post('update-status-order/{id}',[OrderController::class,'update']);
    //Donor
    Route::get('view-donor',[DonorController::class,'index']);
    Route::get('edit-donor/{id}',[DonorController::class,'edit']);
    Route::post('update-donor/{id}',[DonorController::class,'update']);

    // Dasboard
    Route::get('view-dashboard',[DashboardController::class,'index']);
    //Blog
    Route::post('store-blog',[BlogController::class,'store']);
    Route::get('view-blog',[BlogController::class,'index']);
    Route::get('edit-blog/{id}',[BlogController::class,'edit']);
    Route::post('update-blog/{id}',[BlogController::class,'update']);


});
Route::get('view-category',[CategoryController::class,'index']);
Route::get('view-product',[ProductController::class,'index']);
Route::get('view-slider',[SliderController::class,'index']);
//Order
Route::post('order',[OrderController::class,'store']);
//Donate
Route::post('store-donor',[DonorController::class,'store']);
Route::get('all-donor',[DonorController::class,'indexAll']);

