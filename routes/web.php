<?php

use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\BrandController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ColorController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ImageController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Middleware\Dashboard\AuthMiddleware;
use App\Http\Middleware\Dashboard\DashboardMiddleware;
use Illuminate\Support\Facades\Route;




Route::group(['prefix'=>'admin'],function(){
    Route::get('/',[AuthController::class,'login'])->name('auth.login');
    Route::post('/login',[AuthController::class,'authenticate'])->name('auth.authenticate');


    Route::middleware(AuthMiddleware::class)->group(function(){

    //logout
    Route::get('/logout',[AuthController::class,'logout'])->name('auth.logout');


    // dashboard route
      Route::middleware(DashboardMiddleware::class)->group(function(){
        Route::get('/dashboard',[DashboardController::class ,'index'])->name('dashboard.index');
           // user
        Route::get('/user',[UserController::class,'index'])->name("user.index");
        Route::get('/user/list',[UserController::class, 'list'])->name('user.list');
        Route::post('/user/store',[UserController::class,'store'])->name('user.store');
        Route::post('/user/delete',[UserController::class,'delete'])->name('user.delete');
    });
    

 
     //brand
    Route::get('/brand',[BrandController::class,'index'])->name("brand.index");
    Route::get('/brand/list',[BrandController::class, 'list'])->name('brand.list');
    Route::post('/brand/store',[BrandController::class,'store'])->name('brand.store');
    Route::post('/brand/edit',[BrandController::class,'edit'])->name('brand.edit');
    Route::post('/brand/update',[BrandController::class,'update'])->name('brand.update');
    Route::post('/brand/delete',[BrandController::class,'delete'])->name('brand.delete');


    //category router
    Route::get('/category',[CategoryController::class,'index'])->name("category.index");
    Route::get('/category/list',[CategoryController::class, 'list'])->name('category.list');
    Route::post('/category/store',[CategoryController::class,'store'])->name('category.store');
    Route::post('/category/edit',[CategoryController::class,'edit'])->name('category.edit');
    Route::post('/category/update',[CategoryController::class,'update'])->name('category.update');
    Route::post('/category/delete',[CategoryController::class,'delete'])->name('category.delete');
    Route::post('/category/upload',[CategoryController::class,'upload'])->name('category.upload'); /*for img*/
    Route::post('/category/cancel-image',[CategoryController::class,'cancelImage'])->name('category.cancel.image');


    //color
    Route::get('/color',[ColorController::class,'index'])->name("color.index");
    Route::get('/color/list',[ColorController::class, 'list'])->name('color.list');
    Route::post('/color/store',[ColorController::class,'store'])->name('color.store');
    Route::post('/color/edit',[ColorController::class,'edit'])->name('color.edit');
    Route::post('/color/update',[ColorController::class,'update'])->name('color.update');
    Route::post('/color/delete',[ColorController::class,'delete'])->name('color.delete');

       //color
    Route::get('/product',[ProductController::class,'index'])->name("product.index");
    Route::get('/product/list',[ProductController::class, 'list'])->name('product.list');
    Route::post('/product/store',[ProductController::class,'store'])->name('product.store');
    Route::post('/product/data',[ProductController::class,'data'])->name('product.data');
    Route::post('/product/edit',[ProductController::class,'edit'])->name('product.edit');
    Route::post('/product/update',[ProductController::class,'update'])->name('product.update');
    Route::post('/product/delete',[ProductController::class,'delete'])->name('product.delete');

    //profile router
    Route::get('/profile',[ProfileController::class,'index'])->name('profile.index');
    Route::post('/profile/change/password',[ProfileController::class, 'changePassword'])->name('profile.change.password');
    Route::post('/profile/update',[ProfileController::class,'profileUpdate'])->name('update.profile');
    Route::post('/profile/cancel',[ProfileController::class, 'cancel'])->name('cancel.avatar');
    Route::post('/profile/change/avata',[ProfileController::class, 'changeAvata'])->name('change.avata');


    //upload images
    Route::post('/product/upload',[ImageController::class,'uploads'])->name('product.upload');
    Route::post('/product/cancel',[ImageController::class,'cancel'])->name('image.cancel');

    });
});



