<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        return view('back-end.user');
    }
     public function list(){
        $users = User::orderBy('id','desc')->get();
        return response()->json([
            'status'=>200,
            'users'=>$users 
        ]);

    }
    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:4'
        ]);

        if($validator->passes()){
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;
            $user->save();

             return response([
                    'status'=>200,
                    'message'=>'User Create successful'
                ]);
        }else{
            return  response([
                'status'=>500,
                "message"=>"User create failed",
                'errors'=> $validator->errors()
            ]);
        }       
    }

    public function delete(Request $request){
        $user = User::find($request->id);
        //check if user not found --- IGNORE ---
        if($user){
            $user->delete();
            return response()->json([
                'status'=>200,
                'message'=>'User delete successful'
            ]);
        }else{ 
            return response()->json([
                'status'=>404,
                'message'=>'User not found'
            ]); 
        }

}

    //selete all user from users db
   
}
