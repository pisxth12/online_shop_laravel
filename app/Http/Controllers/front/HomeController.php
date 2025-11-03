<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Products;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public  function HomePage(){
    $categories = Category::limit(3)->get();
    $products = Products::orderBy('id', 'desc')->with('Image')->limit(9)->get();
     

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
        // return $product->image;
        // $relatedProduct = Products::where('id', '!=' , $product->id)->with('Image')
        //                             ->take(4)->get();
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
 