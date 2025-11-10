<?php

namespace App\Models\Front;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class BannerController extends Model
{
    public function index(){
        $banners = Banner::orderBy('id', 'desc')->get();
        // return $banners;
        return view('back-end.banner', [
            'banners' => $banners
        ]);
    }
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'banner_image'=>'required',
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


        if($request->banner_image){
            $tempPath = public_path('uploads/temp/' . $request->banner_image);
            $bannerPath = public_path('uploads/banner/' . $request->banner_image);
         
            if(File::exists($tempPath)){
                File::copy($tempPath, $bannerPath);
                File::delete($tempPath);
            }
        }
        $banner = Banner::create([
            'title' => $request->input('title'),
            'image' => $request->input('banner_image'),
            'status' => $request->input('status'),
        ]);

        return response([
            'status'=> 200,
            'message'=> 'Success',
            'image'=> $banner
        ]);
    }
    public function list(Request $request){

        
        $limit = 5;
        $page = $request->page ?? 1;
        $offset = ($page-1) * $limit;
        $banners = Banner::orderBy('id','desc')->limit($limit)->offset($offset)->get();
        $totalRecord = Banner::count();
        $totalPage = ceil($totalRecord/ 5);
       

        return response([
            'status'=> 200,
            'pages'=> [
                'totalRecord' => $totalRecord,
                'totalPage' => $totalPage,
                'currentPage' => $page
            ],
            'banners'=> $banners
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
    public function cancelImage(Request $request){
        if($request->image){
           $tempDir = public_path('uploads/temp/' . $request->image);
           if(File::exists($tempDir)){
            File::delete($tempDir);
            return response()->json([
                'status' => 200,
                'message' => 'Image canceled successfully',
            ]);
           }


        }
    }

    public function deleteBanner(Request $request){
        $banner = Banner::find($request->id);
        if(File::exists(public_path('uploads/banner/' . $banner->image))){
            File::delete(public_path('uploads/banner/' . $banner->image));
            $banner->delete();
        }
        else{
            $banner->delete();
        }
        return response()->json([
            'status' => 200,
            'message' => 'Success',
        ]);
        
    }
    public function edit(Request $request){
        $banner = Banner::find($request->id);
        if(!$banner){
            return response()->json([
                'status' => 404,
                'message' => 'Banner not found',
            ]);
        }
        return response([
            'status' => 200,
            'banner' => $banner,
        ]);
        
    }

    public function updateBanner(Request $request)
{
    $validator = Validator::make($request->all(), [
        'banner_id' => 'required|exists:banners,id',
        'title' => 'required|min:3|max:255',
        'status' => 'required|in:0,1',
    ]);
    
    if ($validator->fails()) {
        return response()->json([
            'status' => 400,
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ]);
    }
    
    $banner = Banner::find($request->banner_id);
    
    // Update title and status
    $banner->title = $request->title;
    $banner->status = $request->status;
    
    // Handle image update if new image is uploaded
    if($request->banner_image) {
        // Delete old image
        $oldPath = public_path('uploads/banner/' . $banner->image);
        if(File::exists($oldPath)){
            File::delete($oldPath);
        }
        
        // Move new image from temp to banner folder
        $tempPath = public_path('uploads/temp/' . $request->banner_image);
        $newPath = public_path('uploads/banner/' . $request->banner_image);
        
        if(File::exists($tempPath)){
            File::copy($tempPath, $newPath);
            File::delete($tempPath);
            
            // Update banner image name
            $banner->image = $request->banner_image;
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Image file not found in temp folder',
            ]);
        }
    }
    
    $banner->save();
    
    return response()->json([
        'status' => 200,
        'message' => 'Banner updated successfully',
        'banner' => $banner,
    ]);
}

}