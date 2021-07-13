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
}
