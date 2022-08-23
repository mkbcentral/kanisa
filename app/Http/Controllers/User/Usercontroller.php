<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Usercontroller extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required|min:4|confirmed',
            'device_name'=>'required'
        ]);

        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);
        return $this->login($request,$request->device_name);
    }

    public function login(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:4',
        ]);
        $creds=$request->only(['email','password']);
        if (Auth::attempt($creds)) {
            $user =auth()->user();

           return response()->json([
                'user'=>$user,
                'token'=>$user->createToken('token')->plainTextToken,
                'device_name'=>$user->device_name,
                'message'=>'Login successfull !'
           ]);
        } else {
            return response()->json([
                'message'=>'Make sure your email and password'
           ],403);
        }
    }

    public function show($id){
        $user=User::find($id);
        return response()->json([
            'user'=>$user
        ]);
    }

    public function update(Request $request, $id){
        $user=User::find($id);
        $user->name=$request->name;
        $user->email=$request->email;
        $image=$this->saveImage($request->avatar,'avatars');
        $user->avatar=$image;
        $user->update();
        return response()->json([
            'user'=>$user,
                'message'=>'Profile update success full !'
            ],200
        );
    }
}
