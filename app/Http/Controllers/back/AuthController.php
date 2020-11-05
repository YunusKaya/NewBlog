<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('back.auth.login');
    }
    public function loginPost(Request $request)
    {
       // return 'email=>'.$request->email.'password=>'.$request->password;
       //return Auth::attempt(['email'=>$request->email,'password'=>$request->password]);
        if (Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
        {
            toastr()->success('Tekrar hoş geldiniz', Auth::user()->name);
            return redirect()->route('admin.dashboard');
        }
        else
        {
            return redirect()->route('admin.login')->withErrors('Email adresi veya şifre hatalı!');
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
