<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    function login (Request $request){
        $email = $request->input('email');
        $password = $request->input('password');
        $user = DB::table('usuario')
            ->where('email', '=', $email)
            ->where('password', '=', $password)
            ->get();
        if($user){
            echo("successful login");
            return view('home');
        }
        else{
            echo("failed login");
        }
        
    }
}
