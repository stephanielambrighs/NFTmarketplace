<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile(){
        $id = 4;
        $user = \DB::table("users")->where('id', $id)->first();
        $data['user'] = $user;
        return view('profile', $data);

    }

    public function updateAvatar(Request $request){
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $path = public_path('../public/images/'.$filename);
            Image::make($avatar)->resize(300, 300)->save($path);

            $user = User::find($request->id);
            $user->avatar = $filename;
            $user->save();
            return redirect('./profile');

           
        }

        
    }

    public function updateUserdata(Request $request){
        
        $user = User::find($request->id);
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->street = $request->input('street');
        $user->housenumber = $request->input('housenumber');
        $user->city = $request->input('city');
        $user->postal = $request->input('postal');
        $user->country = $request->input('country');
        $user->phone = $request->input('phone');
        $user->save();
        return redirect('./profile');
    }



    public function register(){
        return view('signup');
    }

    public function login(){
        return view('login');
    }

    public function store(Request $request){
        $user = new \App\Models\User();
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->phone = $request->input('phone');
        $user->bio = $request->input('bio');
        $user->street = $request->input('street');
        $user->housenumber = $request->input('housenumber');
        $user->city = $request->input('city');
        $user->postal = $request->input('postal');
        $user->country = $request->input('country');
        $user->save();
        return redirect('./');

        
    }

    public function handleLogin(Request $request){
        
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            return redirect('./');
        }else{
            return redirect('./login');
        }


    }

    
}
