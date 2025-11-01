<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public  function HomePage(){
    $categories = Category::limit(3)->get();
    $products = Products::orderBy('id', 'desc')->with('Image')->limit(9)->get();
    return $products;

    // $data[{'categories','products'}] = $categories, $products;
    $data['categories'] = $categories;
    $data['products'] = $products;

     return view('front-end.index', $data) ;
    }
}
