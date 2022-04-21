<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Director;

class DirectorLoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest:director')->except('logout');
    }

    public function showLoginForm()
    {
        return view('director.auth.login');
    }

    public function login(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'email' => 'required|email', //VALIDASI KOLOM USERNAME
            //TAPI KOLOM INI BISA BERISI EMAIL ATAU USERNAME
            'password' => 'required|string|min:6',
        ]);
        
        $directors = Director::where('email', $request->email)->first();
        //dd($directors);
        if(Auth::guard('director')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => '1'], $request->remember))
        {
            
            return redirect(route('director.home'));
        }
        return redirect()->route('director.login')->with(['error' => 'Email/Kata Sandi tidak sesuai.'])->withInput($request->only('email','remember'));
    }

    public function logout(Request $request)
    {
        auth()->guard('director')->logout(); //JADI KITA LOGOUT SESSION DARI GUARD CUSTOMER
        return redirect(route('director.login'));
    }

    protected function loggedOut(Request $request)
    {
        //
    }

    protected function guard()
    {
        return Auth::guard('director');
    }
}
