<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('back-end.brand', compact('categories'));
    }
    public function list(Request $request)
    {
        $limit = 5;
        $page = $request->page;

        $offset = ($page - 1) * $limit;
        $totalRecord = Brand::count();

        if (!empty($request->search)) {
            $brands = Brand::where('name', 'like', '%' . $request->search . '%')->orderBy('id', 'asc')->with('category')->limit($limit)->offset($offset)->get();
            $totalRecord = Brand::where('name', 'like', '%' . $request->search . '%')->count();
        } else {
            $brands = Brand::orderBy('id', 'asc')->with('category')->limit($limit)->offset($offset)->get();
            $totalRecord = Brand::count();
        }
        $totalPage = ceil($totalRecord / 5);
        return response([
            'status' => 200,
            'page' => [
                'totalRecord' => $totalRecord,
                'totalPage' => $totalPage,
                'currentPage' => $page
            ],
            'brands' => $brands
        ]);

        if (empty($brands)) {
            return response([
                'status' => 404,
                'message' => "Brand is Empty",
            ]);
        }
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name',
            'category' => 'required|exists:categories,id',
        ]);
        if ($validator->fails()) {
            return response([
                'status' => 500,
                'message' => "Store brand faild",
                'errors' => $validator->errors()

            ]);
        }
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->category_id = $request->category;
        $brand->status = $request->status;

        $brand->save();
        return response([
            'status' => 200,
            'message' => "Brand Store success",
        ]);
    }

    public function delete(Request $request)
    {
        $brand = Brand::find($request->id);
        if (!$brand) {
            return response([
                'status' => 404,
                'message' => "Brand Delete failed with id " . $request->id,

            ]);
        }

        $brand->delete();
        return response()->json([
            'status' => 200,
            'message' => "Brand Delete successfully",
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 404,
                'message' => "Cant find Brand id" . $request->brand_id
            ]);
        }
        $brand = Brand::find($request->brand_id);
        $brand->name = $request->name;
        $brand->category_id = $request->category;
        $brand->status = $request->status;

        $brand->save();

        return response([
            'status' => 200,
            'message' => "Brand delete successfully",
        ]);
    }
}
