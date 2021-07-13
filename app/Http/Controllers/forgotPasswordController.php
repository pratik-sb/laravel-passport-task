<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class forgotPasswordController extends Controller
{
    public function forgot(Request $req){
        $validatedData = $req->validate([
            'email'=>'email|required',
        ]);

        if (User::where('email', '=', $req->email)->count() == 0) {
            return response(['message'=>'Account Not found with given email!']);
         }

        Password::sendResetLink($validatedData);

        return response(['message'=>'Reset Link Sent On Email Address!']);
    }

    public function reset(Request $req){
        $validatedData = $req->validate([
            'email'=>'email|required',
            'password'=>'required|max:20|confirmed',
            'token'=>'required'
        ]);
        $emailpassStatus = Password::reset($validatedData, function($user, $password){
            $user->password = $password;
            $user->save();
        });

        if($emailpassStatus == Password::INVALID_TOKEN){
            return response(['message'=>'Bad Request!']);
        }

        return response(['message'=>'Success! Password Successfully Changed!']);
    }
}
