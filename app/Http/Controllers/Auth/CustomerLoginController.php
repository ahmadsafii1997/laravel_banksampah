<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Customer;
use Illuminate\Http\Request;

class CustomerLoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest:customer')->except('logout');
    }

    public function showLoginForm()
    {
        return view('customer.auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string', 
            'password' => 'required|string',
        ]);

        $customers = Customer::where('username', $request->username)->first();
        //dd($customers);
        if(Auth::guard('customer')->attempt(['username' => $request->username, 'password' => $request->password, 'status' => '1'], $request->remember))
        {
            return redirect('/customer');
        }
        return redirect()->route('customer.login')->with(['error' => 'Email/Kata Sandi tidak sesuai.'])->withInput($request->only('username','remember'));
        
    }

    public function logout(Request $request)
    {
        auth()->guard('customer')->logout(); //JADI KITA LOGOUT SESSION DARI GUARD CUSTOMER
        return redirect(route('customer.login'));
    }

    protected function loggedOut(Request $request)
    {
        //
    }

    protected function guard()
    {
        return Auth::guard('customer');
    }
}
