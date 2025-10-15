<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Route;

//user router
Route::get('/user',[UserController::class,'index'])->name("user.index");
Route::get('/user/list',[UserController::class, 'list'])->name('user.list');
Route::post('/user/store',[UserController::class,'store'])->name('user.store');
Route::post('/user/delete',[UserController::class,'delete'])->name('user.delete');


//category router
Route::get('/category',[CategoryController::class,'index'])->name("category.index");
Route::get('/category/list',[CategoryController::class, 'list'])->name('category.list');
Route::post('/category/store',[CategoryController::class,'store'])->name('category.store');
Route::post('/category/edit',[CategoryController::class,'edit'])->name('category.edit');
Route::post('/category/update',[CategoryController::class,'update'])->name('category.update');
Route::post('/category/delete',[CategoryController::class,'delete'])->name('category.delete');
 Route::post('/category/upload',[CategoryController::class,'upload'])->name('category.upload'); /*for img*/
 Route::post('/category/cancel-image',[CategoryController::class,'cancelImage'])->name('category.cancel.image');