<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('back-end.color');
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'color' => 'required',
        ]);
        if ($validator->passes()) {
            $colors = new Color();
            $colors->name = $request->name;
            $colors->color_code = $request->color;
            $colors->status = $request->status;
            $colors->save();

            return response([
                'status' => 200,
                'message' => "Store Color Successfully",
                'colors' => $colors,
            ]);
        } else {
            return response([
                'status' => 400,
                'message' => "error validator" . $validator->errors()
            ]);
        }
    }
    public function list(Request $request)
    {

        $limit = 5;
        $page = $request->page;

        $offset = ($page -1) * $limit;

        $totalRecord = Color::count();

        if (!empty($request->search)) {
            $colors = Color::where('name','like','%'. $request->search .'%')->orderBy('id','asc')->limit($limit)->offset($offset)->get();
            $totalRecord = Color::where('name','like','%'. $request->search .'%')->count();
        }else{
            $colors = Color::orderBy('id','asc')->limit($limit)->offset($offset)->get();
            $totalRecord = Color::count();
        }
        $totalPage= ceil($totalRecord / 5);
        
        return response()->json([
            'status' => 200,
            'page'=>[
                'totalPage'=>$totalPage,
                'totalRecord'=>$totalRecord,
                'currentPage'=>$page
            ],
            'colors' => $colors
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'color' => 'required',
        ]);
        if ($validator->passes()) {
            $color = Color::find($request->color_id);
            $color->name = $request->name;
            $color->color_code = $request->color;
            $color->status = $request->status;
            $color->save();

            return response()->json([
                'status' => 200,
                'message' => 'Color edit successfully',
                'color' => $color
            ]);
        } else {
            return response([
                'status' => 400,
                // 'message'=>"Error ". $validator->errors()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $color = Color::find($request->id);
        $color->delete();
        return response()->json([
            'status' => 200,
            'message' => "Color Delete success" . $request->id
        ]);
    }
}
