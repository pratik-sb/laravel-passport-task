<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class checkRouteGaurdController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }//

    public function check(){
        return response(['message'=>'Token in valid!']);
    }

    public function scopecheck(Request $req){
        if ($req->user()->tokenCan('get-admin')) {
            return response(['message'=>'SUCCESS! Admin Data!!']);
        }elseif ($req->user()->tokenCan('get-business')) {
            return response(['message'=>'SUCCESS! Business Data!!']);
        }elseif ($req->user()->tokenCan('get-user')) {
            return response(['message'=>'SUCCESS! User Data!!']);
        }else{
            return response(['message'=>'Failed! You Dont have access to this!']);
        }
        
    }
}
