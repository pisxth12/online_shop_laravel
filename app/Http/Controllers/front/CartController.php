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
            return view('front-end.cart.cart_list');
        }
        return redirect()->route('customer.login');
    }

    public function add($id)
    {
        $product = Products::where('id', $id)->first();

        if(!Auth::check()){
            return redirect()->route('customer.login');
        }
        if (!$product) {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found',
            ]);
        }

        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity'=> $product->qty,
            'image' => $product->image,
        ]);


        return redirect()->route('cart.view')->with('success', 'Product added to cart');
    }

    public function remove($id)
    {
        Cart::remove($id);
        return redirect()->with('success', 'Product removed from cart');
    }
}
