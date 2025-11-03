<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function showRegister(){
        return view('front-end.Auth.Register');
    }

    public function processRegister(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'phone'=> 'required|string|unique:users,phone',
            'password' => 'required|min:5',
            'confirm_password' => 'required|same:password',
        ]);
        if($validator->fails()){
            
            return redirect()->back()->withErrors($validator);

        }else{

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->password = $request->input('password');
        $user->role = 2;
        $user->save();

        return redirect()->route('customer.login')->with('success', 'User registered successfully');
        }
        
    }
    public function showLogin(){
        return view('front-end.Auth.Login');
    }

    public function processLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return redirect()->route('customer.login')->withErrors($validator);
        }else{

            $credentials = $request->only('email', 'password');
            if(Auth::attempt($credentials)){
                if(Auth::user()->role == 2){
                    return redirect()->route('home.page');
                }else{
                    Auth::logout();
                    return redirect()->route('customer.login')->with('error', 'Invalid credentials');
                }
            }else{
               
                return redirect()->route('customer.login')->with('error', 'Invalid credentials');
            }
        }

    }
}
