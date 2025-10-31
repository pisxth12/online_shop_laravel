<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Avatar;
use App\Models\Contact;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $contacts = Contact::where('user_id', $user->id)->pluck( 'contact_url', 'contact_name')->toArray();
        $avatars = $user->avatars;
        $address = UserAddress::where('user_id', $user->id)->first();
        return view('back-end.profile', [
            'avatars' => $avatars ,
            'users'=> $user,
            'contacts'=> $contacts,
            'address'=> $address
        ]);
    }
    public function changePassword(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'current_pass' => 'required',
            'new_pass' => 'required',
            'c_password' => 'required|same:new_pass'
        ]);
        Session::flash('password');

        $user = Auth::user();
        if (!password_verify($request->current_pass, $user->password)) {
            return redirect()->back()->with('error', 'Invalid password');
        }

        if ($validator->passes()) {

            $current_password  = $request->current_pass;
            $user = User::find(Auth::user()->id);
            if (password_verify($current_password, $user->password)) {
                $user->password = Hash::make($request->new_pass);
                $user->save();
                session()->flash('success', 'Password changed');
                return redirect()->back();
            }
        } else {
            return redirect()->back()->withErrors($validator);
        }
    }

    public function profileUpdate(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }
        Auth::user();
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:250',
            'email' => 'required|email|unique:users,email,' . Auth::user()->id,
            'phone' => 'required|max:20|unique:users,phone,' . Auth::user()->id,
            'contact_name' => 'nullable|string|max:255',
            'contact_url'  => 'nullable|url|max:255',
            'address'=> 'required|string|max:255'
        ]);

        Session::flash('avatar');

        if ($validator->passes()) {
            $user =  User::find(Auth::user()->id);

            $user->name  = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            


            if(!empty($request->profile)){
                $imageName = $request->profile;
                $userDir = public_path('uploads/user/'. $imageName);
                $tempDir = public_path('uploads/temp/'. $imageName);
                if(File::exists($tempDir)){
                    File::move($tempDir, $userDir);
                    // File::delete($tempDir);
                }
            }
            Avatar::where('user_id', $user->id)->update(['is_current'=>false]);

            if(!empty($request->profile)){
                Avatar::create([
                    'user_id'    => $user->id,
                    'filename'   => $imageName,
                    'is_current' => true,
                ]);
                $user->image = $imageName;

            }
            $user->save();

            $contactNames = ['Facebook','Telegram'];
            $links = $request->input('link');
            $existContact = Contact::where('user_id', $user->id)->first();

            foreach($contactNames as $index => $name){
                $link = $links[$index]?? null;
                if(!empty($link)){
                    $existContact = Contact::where('user_id', $user->id)->where('contact_name', $name)->first();
                    if($existContact != null){
                        $existContact->update([
                            'contact_url'=>$link
                        ]);
                    }else{
                        Contact::create([
                            'user_id'      => $user->id,
                            'contact_name' => $name,
                            'contact_url'  => $link
                        ]);
                    }

                }

            }
            
            $address = UserAddress::where('user_id', $user->id)->first();
            $addressName = $request->address;
            if(!empty($address)){
               $address->update([
                'address'=>  $addressName
               ]);
            }else{
                 UserAddress::create([
                    'user_id'=> $user->id,
                    'address'=> $request->address
                ]);
            }

           


            session()->flash('success', 'Profile updated successfully.');
            return redirect()->back();
        } else {
            Session::flash('error', 'error validator' . $validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function changeAvata(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required'
        ]);

        Session::flash('avatar');
        if ($validator->passes()) {

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = rand() . '.' . $image->getClientOriginalExtension();
                $image->move('Uploads/temp/', $imageName);
            }
            return response([
                'status' => 200,
                'message' => "Uploads avatar successfully",
                'avatar' => $imageName
            ]);
        } else {
            return response([
                'status' => 400,
                'message' =>  'Error validator'
            ]);
        }
    }

    public function cancel(Request $request){

        $avatar = $request->avatar;
        $temp_dir = public_path('uploads/temp/'.$avatar);

        if($avatar && file_exists($temp_dir)){
            File::delete($temp_dir);
            return response([
                'status'=>200,
                'message'=>"cancel success"
            ]); 
        }
      

        return response([
            'status'=>400,
            'message'=>'cancel fieled'
        ]);
    }
}
