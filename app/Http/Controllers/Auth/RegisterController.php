<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function index(){
        $title = "register";
        return view('auth.login_siswa',compact(
            'title',
        ));
    }

    public function store(Request $request){
        $this->validate($request ,[
            'name'=>'required|max:100',
            'no_tlp'=>'required|email',
            'password'=>'required|max:200|confirmed',
        ]);

        $user = User::create([
            'name'=>$request->name,
            'no_tlp'=>$request->no_tlp,
            'password'=>Hash::make($request->password),
            'level' => 4,
        ]);
        return redirect()->route('dashboard');
    }
}
