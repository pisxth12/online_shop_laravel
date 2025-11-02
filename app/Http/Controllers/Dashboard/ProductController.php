<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\ProductImage;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    public function index()
    {
        $products = Products::limit(9)->get();
        $categories = Category::limit(9)->get();

        $data = [
            'products'=>$products,
            'categories'=> $categories
        ] ;

        return view('back-end.product',$data);
    }

  public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'title' => 'required',
        'price' => 'required',
        'qty' => 'required',
        'image.*' => 'nullable|image'
    ]);

    if ($validator->passes()) {

        //save product
        $product = new Products();
        $product->name = $request->title;
        $product->category_id = $request->category;
        $product->desc = $request->desc;
        $product->price = $request->price;
        $product->qty = $request->qty;
        $product->brand_id = $request->brand;
        $product->user_id = Auth::user()->id;
        $product->color = implode(",", $request->color);
        $product->status = $request->status;
        $product->save();

        $images = [];
        
       
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                $fileName = rand(0,999999999) . '.' . $file->getClientOriginalExtension();
                
                $file->move(public_path('uploads/product'), $fileName);
                
                $productImage = new ProductImage();
                $productImage->product_id = $product->id;
                $productImage->image = $fileName;
                $productImage->save();

                $images[] = $productImage;
            }
        }

        return response([
            'status' => 200,
            'message' => 'Product add success',
            "data" => [
                'product_id' => $product->id,
                'images' => $images
            ]
        ]);
    } else {
        return response()->json([
            'status' => 500,
            'message' => "error validator",
            'errors' => $validator->errors()
        ]);
    }
}

    public function list(Request $request)
    {
        $limit = 5;
        $page = $request->page ?? 1;
        $offset = ($page - 1) * $limit;
        $search = $request->search;

        $query = Products::with(['Category', 'Brand', 'Image']);


        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhereHas('Category', function ($q2) use ($search) {
                        $q2->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('Brand', function ($q3) use ($search) {
                        $q3->where('name', 'like', '%' . $search . '%');
                    });
            });
        }
        $totalRecord = $query->count();
        $products = $query->orderBy('id', 'desc')->limit($limit)->offset($offset)->get()
            ->map(function ($field) {
                $field->colors_data = $field->colors()->get();
                return $field;
            });

        $totalPage = ceil($totalRecord / $limit);

        if ($products->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => "Product not found",
                'products' => [],
                'page' => [
                    'totalRecord' => $totalRecord,
                    'totalPage' => $totalPage,
                    'currentPage' => $page
                ]
            ]);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Product list get successfully',
            'pages' => [
                'totalRecord' => $totalRecord,
                'totalPage' => $totalPage,
                'currentPage' => $page
            ],
            'products' => $products
        ]);
    }

    public function data()
    {
        $categories = Category::orderBy('id', 'asc')->get();
        $brands = Brand::orderBy('id', 'asc')->get();
        $colors = Color::orderBy('id', 'asc')->get();

        return response([
            'status' => 200,
            'data' => [
                'Categories' => $categories,
                'brands' => $brands,
                'colors' => $colors
            ]
        ]);
    }

    public function delete(Request $request)
    {
        $product = Products::find($request->id);
        if (!$product) {
            return response([
                'status' => 404,
                'message' => "Product not found"
            ]);
        }

        $images = ProductImage::where('product_id', $product->id)->get();

        foreach ($images as $image) {
            $image_path = public_path('uploads/product/' . $image->image);
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            $image->delete();
        }

        $product->delete();

        return response([
            'status' => 200,
            'message' => "Product delete successfully",
        ]);
    }
    public function edit(Request $request)
    {
        $product = Products::find($request->id);
        if (!$product) {
            return response([
                'status' => 404,
                'message' => "Product not found"
            ]);
        }


        $categories = Category::orderBy('id', 'asc')->get();
        $brands = Brand::orderBy('id', 'asc')->get();
        $colors = Color::orderBy('id', 'asc')->get();
        $productImage = ProductImage::where('product_id', $request->id)->get();


        return response()->json([
            'status' => 200,
            'data' => [
                'product' => $product,
                'productImage' => $productImage,
                'categories' => $categories,
                'brands' => $brands,
                'colors' => $colors
            ]
        ]);
    }

    public function update(Request $request)
    {
        $product = Products::find($request->id_edit);

        // Update product info
        $product->name = $request->title;
        $product->desc = $request->desc;
        $product->qty = $request->qty;
        $product->price = $request->price;
        $product->brand_id = $request->brand;
        $product->category_id = $request->category;
        $product->color = implode(',', $request->color);

        $product->save(); // save basic info first

        if ($request->has('image_uploads') && count($request->image_uploads) > 0) {
            $oldImages = ProductImage::where('product_id', $product->id)->get();

            foreach ($request->image_uploads as $fileName) {
                $tempPath = public_path('uploads/temp/' . $fileName);
                $productPath  = public_path('uploads/product/' . $fileName);

                if (File::exists($tempPath)) {
                    File::move($tempPath, $productPath);
                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                    $productImage->image = $fileName;
                    $productImage->save();
                }
            }
        }

        return response()->json([
            'status' => 200,
            'message' => "Product updated successfully",
            'data' => [
                'product' => $product,
            ]
        ]);
    }
}