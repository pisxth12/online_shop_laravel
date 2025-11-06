<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\Mail\CustomerEmail;
use App\Models\PasswordResetToken;
use App\Models\User;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function showRegister()
    {
        return view('front-end.Auth.Register');
    }

    public function processRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|min:5',
            'confirm_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        } else {

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
    public function showLogin()
    {
        return view('front-end.Auth.Login');
    }

    public function processLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('customer.login')->withErrors($validator);
        } else {

            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials, $request->filled('remember_me'))) {
                if (Auth::user()->role == 2) {
                    return redirect()->route('home.page');
                } else {
                    Auth::logout();
                    return redirect()->route('customer.login')->with('error', 'error email or password');
                }
            } else {

                return redirect()->route('customer.login')->with('error', 'error email or password');
            }
        }
    }

    public function viewForgotPassword()
    {
        return view('front-end.Auth.forget_password');
    }
    public function processForgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);
        if ($validator->fails()) {
            return redirect()->route('customer.forgot_password')->withErrors($validator);
        }
        $code = mt_rand(100000, 999999);
        $token = hash('sha256', random_bytes(128));

        PasswordResetToken::updateOrCreate(
            ['email' => $request->email],
            [
                'token' => $token,
                'code' => $code,
                'expire_at' => now()->addMinutes(30),
            ]
        );

        $user  = User::where('email', $request->email)->first();
        //only for admin
        if ($user->role == 1) {
            return redirect()->route('customer.login')->with('error', 'you have no pemission to reset password');
        }
        //end only  for admin

        $data = [
            'name' => $user->name,
            'code' => $code,
            'token' => $token,
            'email' => $user->email,
        ];



        Mail::to($request->email)->send(new CustomerEmail($data));

        return redirect()->route(
            'verify.code.show',
            ['token' => $token]
        )->with('success', 'Verification code sent to your email');
    }


    public function CodeSendVerify(string $token)
{
    $tokenData = PasswordResetToken::where('token', $token)->first();
    if ($tokenData && $tokenData->expire_at > now()) {
        return view('front-end.Auth.sent_code_verify', compact('tokenData'));
    }
    return redirect()->route('customer.login')->with('error', "Token expired or invalid token");
}

public function processVerifyCode(Request $request)
{
    $validator = Validator::make($request->all(), [
        'code' => 'required|numeric',
        'token' => 'required|string'
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator);
    }

    $tokenData = PasswordResetToken::where('token', $request->token)->first();

    if (!$tokenData) {
        return redirect()->back()->with('error', 'Token expired or invalid token');
    }

    if ($tokenData->code != $request->code || $tokenData->expire_at <= now()) {
        return redirect()->back()->withErrors(['code' => 'Invalid verification code or token expired']);
    }

    return redirect()->route('reset.password.show', [
        'code' => $tokenData->code,
        'token' => $tokenData->token
    ])->with('success', 'Code verified successfully');
}

public function showResetPassword(string $code, string $token)
{
    $tokenData = PasswordResetToken::where('token', $token)
        ->where('code', $code)
        ->first();
        
    if (!$tokenData) {
        return redirect()->route('customer.login')->with('error', 'Token expired or invalid token');
    }

    if ($tokenData->expire_at <= now()) {
        return redirect()->route('customer.login')->with('error', 'Token has expired');
    }
    
    return view('front-end.Auth.new_password', compact('tokenData'));
}

public function processResetPassword(Request $request)
{
    $validator = Validator::make($request->all(), [
        'code' => 'required|numeric',
        'token' => 'required|string',
        'password' => 'required|min:5', 
        'confirm_password' => 'required|same:password'
    ]);
    
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator);
    }

    $tokenData = PasswordResetToken::where('token', $request->token)
        ->where('code', $request->code)
        ->first();
        
    if (!$tokenData || $tokenData->expire_at <= now()) {
        return redirect()->route('customer.login')->with('error', 'Token expired or invalid');
    }

    $user = User::where('email', $tokenData->email)->first();
    
    if (!$user) {
        return redirect()->route('customer.login')->with('error', 'User not found');
    }


    $user->password = bcrypt($request->password);
    $user->save();

    $tokenData->delete();

    return redirect()->route('customer.login')->with('success', 'Password reset successfully. Please login with your new password.');
}



}