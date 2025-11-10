<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class CartController extends Controller
{
      public function index()
    {
        if (Auth::check()) {
            $cartItems  = Cart::getContent();

            return view('front-end.cart.cart_list', [
                'cartItems' => $cartItems,
            ]);
        }
        return redirect()->route('customer.login');
    }

    public function add($id)
    {
        $product = Products::where('id', $id)->with('Image','Brand')->limit(1)->first();

        // $image = $product->image;

 
        if(!Auth::check()){
            return redirect()->route('customer.login');
        }
        if (!$product) {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found',
            ]);
        }
      
        $item = Cart::get($product->id);

        if($item){
           Cart::update($product->id,[
            'quantity' => 1,
           ]);
        }else{
            Cart::add([
                'id' => $product->id,
                'name'=> $product->name,
                'price'=> $product->price,
                'quantity'=> 1,
                'attributes' => [
                    'image'=> count($product->image) > 0 ? $product->image[0]->image : null,
                    'color'=> $product->color,
                    'brand_name'=> $product->brand->name,
                   
                ]

            ]);
        }
  
        


        return redirect()->route('cart.view')->with('success', 'Product added to cart');
    }

    public function remove($id)
    {
        Cart::remove($id);
        return redirect()->route('cart.view')->with('success', 'Product removed from cart');
    }
}
