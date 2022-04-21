<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string', 
            'password' => 'required|string|min:6',
        ]);
        
        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'status'=> '1'], $request->remember))
        {
            return redirect('/admin/home');
        }
        return redirect()->route('admin.login')->with(['error' => 'Email/Kata Sandi tidak sesuai.'])->withInput($request->only('email','remember'));
    }

    public function logout(Request $request)
    {
        auth()->guard('admin')->logout(); 
        return redirect(route('admin.login'));
    }

    protected function loggedOut(Request $request)
    {
        //
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }
}
