<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {   
        $query = $request->input('query');


        $products = Products::where('name', 'like', "%{$query}%")
            ->orWhereHas('Brand', function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->get();

        return view('front-end.search.ResultSearch',compact('products', 'query'));

    }
}
