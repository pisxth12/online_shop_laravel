<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('back-end.category');
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name',

        ]);
        if ($validator->passes()) {
            //code here to store data in database

            $category = new Category();
            $category->name = $request->name;
            $category->status = $request->status;

            //change image directory


            $tempDir = public_path('uploads/temp/' . $request->input('category_image'));
            $categoryDir = public_path('uploads/category/' . $request->input('category_image'));
            if (File::exists($tempDir)) {
                File::copy($tempDir, $categoryDir);
                File::delete($tempDir);
            }

            $category->image = $request->input('category_image');



            $category->save();


            return response()->json([
                'status' => 200,
                'message' => 'Category created successfully',
                'data' => $request->all()
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong',
                'errors' => $validator->errors(),
            ]);
        }
    }


    public function list()
    {
        $categories =  Category::orderBy('id', 'DESC')->get();
        return response()->json([
            'status' => 200,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */


    public function delete(Request $request)
    {
        $category = Category::find($request->id);
        if ($category->image) {
            $imagePath = public_path("uploads/category/$category->image");
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
            $category->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Category deleted successfully',
            ]);
        }
        $category->delete();
        return response([
            'status' => 200,
            "message" => "Product Delete success",
            "product" => $category
        ]);
    }


    public function upload(Request $request)
    {
        $category = Category::find($request->category_id);
        $validator = Validator::make($request->all(), [
            'image' => 'required',
        ]);
        if ($validator->passes()) {
            if (!empty($request->file('image'))) {
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $imageName = rand(0, 999999999) . "." .  $ext;
                $file->move('uploads/temp', $imageName);
                return response()->json([
                    'status' => 200,
                    'message' => 'Image uploaded successfully',
                    'image' => $imageName,
                    'category'=>$category
                    
                ]);
            }
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong',
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function edit(Request $request)
    {
        $category = Category::find($request->id);
        if (!empty($category)) {
            return response()->json([
                'status' => 200,
                'category' => $category,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No category found',
            ]);
        }
    }

    public function cancelImage(Request $request)
    {
        if ($request->image) {
            $tempDir = public_path("uploads/temp/$request->image");
            if (File::exists($tempDir)) {
                File::delete($tempDir);
                return response()->json([
                    'status' => 200,
                    'message' => 'Image deleted successfully',
                ]);
            }
        }
    }



public function update(Request $request)
{
    $category = Category::find($request->category_id);
    if ($category == null) {
        return response()->json([
            'status' => 400,
            'message' => "Category not found: " . $request->category_id,
        ]);
    }

    // Validate input
    $validator = Validator::make($request->all(), [
        'name' => 'required|unique:categories,name,' . $request->category_id,
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 422,
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ]);
    }

    // Update basic fields
    $category->name = $request->name;
    $category->status = $request->status;

    // Default image value (in case no change)
    $image = $category->image;

    // If new image uploaded (from temp folder)
    if (!empty($request->input('category_image'))) {
        $tempDir = public_path('uploads/temp/' . $request->input('category_image'));
        $categoryDir = public_path('uploads/category/' . $request->input('category_image'));

        if (File::exists($tempDir)) {
            File::copy($tempDir, $categoryDir);
            File::delete($tempDir);
        }

        // Delete old category image
        if (!empty($category->image)) {
            $oldPath = public_path('uploads/category/' . $category->image);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }

        $image = $request->input('category_image');
    }

    // Update image field
    $category->image = $image;

    // Save changes
    $category->save();

    return response()->json([
        'status' => 200,
        'message' => 'Category updated successfully',
        'data' => $category
    ]);
}

    


}
