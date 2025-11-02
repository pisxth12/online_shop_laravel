<?php

use App\Http\Controllers\front\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/',[HomeController::class, 'HomePage']);
Route::get('/viewProduct/{id}', [HomeController::class, 'view'])->name('product.view');