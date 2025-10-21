<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    public function uploads(Request $request){
       if($request->hasFile('image')){
        $images = [];
        $files = $request->file('image');
        foreach ($files as $file) {
            $fileName = rand().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/temp'),$fileName);
            $images[] = $fileName;
        }
       }
       return response([
        'status'=>200,
        "message"=>"Image uploads success",
        'images'=>$images
       ]);
    }
    public function cancel(Request $request){
       $temp_path = public_path("uploads/temp/". $request->image);
       if(File::exists($temp_path)){
        File::delete($temp_path);
        return response([
            'status'=>200,
            'message'=>"Image canceled"
        ]);
       }
    }
}
