<?php

use App\Http\Controllers\Front\CustomerController;
use App\Http\Controllers\front\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'HomePage'])->name('home.page');
Route::get('/viewProduct/{id}', [HomeController::class, 'view'])->name('product.view');
Route::get('/prduct/detail/{id}', [HomeController::class, 'detail'])->name('product.detail');

Route::middleware('guest.customer')->group(function () {
    Route::get('/register', [CustomerController::class, 'showRegister'])->name('customer.register');
    Route::post('/register/process', [CustomerController::class, 'processRegister'])->name('customer.register.process');

    Route::get('/login', [CustomerController::class, 'showLogin'])->name('customer.login');
    Route::post('/login/process', [CustomerController::class, 'processLogin'])->name('customer.login.process');
});
