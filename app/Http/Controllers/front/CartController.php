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
    if (!Auth::check()) {
        return redirect()->route('customer.login');
    }

    $cartItems = Cart::getContent();

    if ($cartItems->count() == 0) {
        return redirect()->route('shop.page')->with('info','Your cart is empty');
    }

    return view('front-end.cart.cart_list', compact('cartItems'));
}

        // public function viewProduct(Request $request)
        // {
        //     $id = $request->id;
        //     Cart::where('id', $r)

        //     return v
        // }

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
        return redirect()->back()->with('success', 'Product removed from cart');
    }
    
public function updateQuantity(Request $request){
    $id = $request->id;
    $quantity = (int) $request->quantity;

    $cartItem = Cart::get($id);
    if(!$cartItem){
        return response()->json([
            'status' => 404,
            'message' => 'Product not found'
        ]);
    }

    $newQty = max(1, $quantity);

    // Correct structure for Darryldecode\Cart
    Cart::update($id, [
        'quantity' => [
            'relative' => false,
            'value' => $newQty
        ]
    ]);

    return response()->json([
        'status' => 200,
        'message' => 'Success',
        'quantity' => $newQty,
        'item_total' => $newQty * $cartItem->price,  // optional: send subtotal
        'cart_total' => Cart::getTotal()             // optional: send total
    ]);
}


}
