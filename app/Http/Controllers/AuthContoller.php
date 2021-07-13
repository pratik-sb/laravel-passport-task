<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthContoller extends Controller
{
    public function register(Request $req){
        $validatedData = $req->validate([
            'name'=>'required|max:50',
            'email'=>'email|required|unique:users',
            'password'=>'required|confirmed'
        ]);
        $validatedData['password'] = bcrypt($validatedData['password']);
        $user  = User::create($validatedData);
        if($user){
            $accessToken = $user->createToken('authtoken')->accessToken;
            $user->sendEmailVerificationNotification();
        }
        return response(['user'=> $user, 'access_token'=>$accessToken]);
    }

    public function login(Request $req){
        $loginData = $req->validate([
            'email'=>'email|required',
            'password'=>'required'
        ]);

        if(!auth()->attempt($loginData)){
            return response(['message'=>'Invalid Credentials']);
        }
        $accessToken = auth()->user()->createToken('authtoken')->accessToken;
        return response(['user'=> auth()->user(), 'access_token'=>$accessToken]);    
    }
}
