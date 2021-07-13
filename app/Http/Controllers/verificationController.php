<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class verificationController extends Controller
{
    public function verify($user_id, Request $req){
        if(!$req->hasValidSignature()){
            return response(['message'=>'INVALID Signature!']);
        }
        $user = User::findorFail($user_id);
        if(!$user->hasVerifiedEmail()){
            $user->markEmailAsVerified();
        }
        return response(['message'=>'Email Verified Successfully!']);
    }

    public function resend(){
        if(auth()->user()->hasVerifiedEmail()){
            return response(['message'=>'Email Already Verified!']);
        }
        auth()->user()->sendEmailVerificationNotification();
        return response(['message'=>'Resent Email Verification Link!']);
    }
}
