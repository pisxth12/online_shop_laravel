<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
            
            return view('back-end.auth.login');
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('auth.login');
    }
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($validator->passes()) {
            $credentials = $request->only('email', 'password');
            $remember = $request->has('remember');
            if (Auth::attempt($credentials , $remember)) {
                if(Auth::user()->role == 1){
                    return redirect()->route('dashboard.index')->with('success','Wellcome Mr admin 😘');
                }else{
                    return redirect()->route('category.index')->with('success', 'Login success');
                }
            } else {
                return redirect()->back()->with('error', 'Invalid password or email');
            }
        } else {
            Session::flash('error', 'Input data');
            return redirect()->back()->withErrors($validator->errors());
        }
    }
}
