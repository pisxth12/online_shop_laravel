<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
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
       $product_path = public_path('uploads/product/'. $request->image);

       if(File::exists($temp_path) || File::exists($product_path) ){
                if(File::exists($temp_path)){
                    File::delete($temp_path);
                }elseif(File::exists($product_path)){
                ProductImage::where('image', $request->image)->delete();
                    File::delete($product_path);
                }else{
                    return response()->json([
                        'status'=>404,
                        'message'=>"Product delete fails". $request->image
                    ]);
                }
       }
       return response([
        'status'=>200,
        'message'=>"Image Cancel Success",
       ]);
    }
}
