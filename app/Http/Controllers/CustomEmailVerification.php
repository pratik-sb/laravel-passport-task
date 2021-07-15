<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\customEmailVerify;
use Hash;
use Illuminate\Support\Str;
use Mail; 

class CustomEmailVerification extends Controller
{
    public function sendemail(Request $req){
        $validatedData = $req->validate([
            'email'=>'email|required',
        ]);

        $user=User::where('email', '=', $req->email)->first();
        if (!$user) {
            return response(['message'=>'Account Not found with given email!']);
        }
         
        if($user->is_email_verified==1){return response(['message'=>'Email Already Verified!']);}
         $token = Str::random(64);
         customEmailVerify::create([
            'user_id' => $user->id, 
            'token' => $token
          ]);

        Mail::send('emailVerificationEmail', ['token' => $token], function($message) use($req){
                $message->to($req->email);
                $message->subject('Email Verification Mail');
            }); 
        //Password::sendResetLink($validatedData);

        return response(['message'=>'Verifcation Link Sent On Email Address!','user'=>$user]);
    }

    public function verifyemail(Request $req){
        $verifyUser = customEmailVerify::where('token', $req->token)->first();
        if (!$verifyUser) {
            return response(['message'=>'Invalid Token!']);
        }
        $user = User::find($verifyUser->user_id);
        $user->is_email_verified = 1;
        $user->save();
        $duser = customEmailVerify::where('user_id', $verifyUser->user_id)->delete();
        return response(['message'=>'Email Verified Successfully']);
    }
}
