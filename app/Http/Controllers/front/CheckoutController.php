<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Products;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {

        if (!Auth::check()) {
            return redirect()->route('customer.login');
        }

      
        $cartItems = Cart::getContent();
        $total = Cart::getTotal();
        $subTotal = Cart::getSubTotal();



        return view('front-end.cart.checkout', compact('cartItems', 'total', 'subTotal'));
    }
}
