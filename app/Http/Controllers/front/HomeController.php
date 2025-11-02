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
    // return $products;

    $data = [
        'categories'=>$categories,
        'products'=>$products
    ];

     return view('front-end.index', $data) ;
    }

    public function view($id){
        $product = Products::with("Image")->find($id);

        if(!$product){
            return response()->json([
                'status'=>404,
                'message'=>"Product not found"
            ]);
        }
        return response()->json([
            'status'=>200,
            'product'=>$product
        ]);
        
    }
}
