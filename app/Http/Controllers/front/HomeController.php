<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public  function HomePage(){
    $categories = Category::limit(3)->get();
    $products = Products::orderBy('id', 'desc')->with('Image')->limit(9)->get();
     $admin = \App\Models\User::where('role', 1)->first();

    $banners = Banner::orderBy('id', 'desc')->get(); 
    $data = [
        'categories'=>$categories,
        'products'=>$products,
        'admin'=> $admin,
        'banners'=> $banners

    ];

     return view('front-end.index', $data) ;
    }
    public function shop(){
        $products = Products::orderBy('id', 'desc')->with('Image')->get();
        $categories = Category::get();
        $brands = Brand::get();
        $colors = Color::get();
        
        if($products->isEmpty()){
            abort(404, 'Product not found');
        }

        $allProduct = [
           
                'products'=> $products,
                'categories'=> $categories,
                'brands'=> $brands,
                'colors'=> $colors
            
            ];
            // return $allProduct;
        
        return view('front-end.shop', compact('allProduct'));
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
            'message'=>'Success',
            'product'=>$product
        ]);
    }
    public function detail(string $id){
        $product = Products::with(['Image','Category', 'Brand'])->find($id);
        

        $colorIds =explode(',', $product->color);
        $colors = Color::whereIn('id', $colorIds)->get();
        
    
        
    
        if(!$product){
             abort(404, 'Product not found');
        }

        $relatedProducts = Products::where('category_id', $product->category_id)
                           ->where('price', '>=', $product->price * 0.8)
                           ->where('price', '<=', $product->price * 1.2)
                           ->where('id', '!=', $product->id)
                           ->take(4)
                           ->get();


        $data = [
            "product"=> $product,
            "productImage"=> $product->image,
            "colors"=> $colors,
            "category"=>$product->category,
            "brand"=>$product->brand,
            'relatedProducts'=> $relatedProducts
            
        ];
           
        return view('front-end.single-product'
        , $data,
    );
    }
    
}
 