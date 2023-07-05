<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(){
        $title = "login";
        return view('auth.login',compact(
            'title',
        ));
    }

    public function login(Request $request){
        $this->validate($request ,[
            'email'=>'required|email',
            'password'=>'required',
        ]);
        dd($request);
       $authenticate = auth()->attempt($request->only('email','password'));
       if (!$authenticate){
           return back()->with('login_error',"Username atau Password Salah!!");
       }

       return redirect()->route('dashboard');
    }
}
