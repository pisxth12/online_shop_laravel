<?php

namespace App\Models\Front;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Validator;

class BannerController extends Model
{
    public function index(){
        return view('back-end.banner');
    
    }
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'image'=>'required',
            'title'=>'required',
            'status'=>'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=> 400,
                'message'=> 'Validation failed',
                'errors'=> $validator->errors(),
            ]);
        }

        if($request->hasFile('image')){
            $file = $request->file('image');
            $fileName = rand(0,999999999) . '.'. $file->getClientOriginalExtension();
            $file->move(public_path('uploads/banner'), $fileName);
        }
        Banner::create([
            'title' => $request->input('title'),
            'status' => $request->input('status'),
        ]);

        return response([
            'status'=> 200,
            'message'=> 'Success',
            'data'=> $fileName
        ]);
    }

   public function upload(Request $request){
    $validator = Validator::make($request->all(),[
        'image' => 'required|image',
    ]);

    if($validator->fails()){
        return response()->json([
            'status' => 400,
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ]);
    }
 
    if($request->hasFile('image')){
        $file = $request->file('image');
        $fileName =  rand(0, 999999999) . '.' . $file->getClientOriginalExtension();
  
        $uploadPath = public_path('uploads/temp');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        
        $file->move($uploadPath, $fileName);
        
        return response()->json([
            'status' => 200,
            'message' => 'Upload success',
            'image' => $fileName,
            'path' => 'uploads/temp/' . $fileName,
        ]);
    }
    return response()->json([
        'status' => 400,
        'message' => 'No image found',
    ]);
}

}
