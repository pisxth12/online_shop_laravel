<?php


use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CustomerController;
use App\Http\Controllers\front\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'HomePage'])->name('home.page');
Route::get('/viewProduct/{id}', [HomeController::class, 'view'])->name('product.view');
Route::get('/product/detail/{id}', [HomeController::class, 'detail'])->name('product.detail');

Route::middleware('guest.customer')->group(function () {
    Route::get('/register', [CustomerController::class, 'showRegister'])->name('customer.register');
    Route::post('/register/process', [CustomerController::class, 'processRegister'])->name('customer.register.process');

    Route::get('/login', [CustomerController::class, 'showLogin'])->name('customer.login');
    Route::post('/login/process', [CustomerController::class, 'processLogin'])->name('customer.login.process');

    // forget password
    Route::get('/view/forget/password',[CustomerController::class,'viewForgotPassword'])->name('customer.view.forgot.password');
    Route::post('/forget/password/process',[CustomerController::class,'processForgotPassword'])->name('customer.process.forgot.password');
    //end forget password

    //verify code
    Route::get('/verify/code/{token}',[CustomerController::class, 'CodeSendVerify' ])->name('verify.code.show');
    Route::post('/verify/code/process',[CustomerController::class,'processVerifyCode'])->name('verify.code.process');
    //end verify code

    //reset password
    Route::get('/reset/{code}/{token}', [CustomerController::class, 'showResetPassword'])->name('reset.password.show');
    Route::post('/reset/process', [CustomerController::class, 'processResetPassword'])->name('reset.password.process');
    //end reset password

    Route::name('cart.')->group(function (){
        Route::get('/view/cart',[CartController::class,'index'])->name('view');
        Route::get('/cart/add/{id}',[CartController::class,'add'])->name('add.to.cart');
        Route::get('/cart/remove/{id}',[CartController::class,'remove'])->name('remove.from.cart');
    });
   

});
