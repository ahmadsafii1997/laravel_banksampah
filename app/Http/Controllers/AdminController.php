<?php

namespace App\Http\Controllers;

use App\Admin;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use DB;
use Cache;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function nganu()
    {
        return view('admin.nganu');
    }
    public function index()
    {
        $admins = Admin::get();
        $admins_ontrashed = Admin::onlyTrashed()->get();
        return view('admin.administrator', compact('admins', 'admins_ontrashed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function message()
    {
        return $message = ([
            'password.*min' => 'Kata sandi minimal :min karakter.', 
            'min' => ':attribute minimal :min karakter.',
            'max' => ':attribute maksimal 255 karakter.',
            'unique' => ':attribute sudah ada, silahkan ganti dengan yang lain.',
            'password.*confirmed' => 'Kata sandi tidak sesuai.',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => "required|string|min:3|unique:admins",
            'email' => "required|string|email|max:255|unique:admins",
            'password' => "required|string|min:5|confirmed",
        ], $this->message());

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(40),
        ]);
        
        return redirect('admin/admin')->with(['success' => 'Admin berhasil ditambahkan']); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => "required|string|min:3|unique:admins,name,$id",
            'email' => "required|string|email|max:255|unique:admins,email,$id",
            'status' => "required",
        ], $this->message());

        $admin = Admin::find($id);

        //dd($request->status);
        
        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ]);
        
        return redirect('admin/admin')->with(['success' => 'Data Admin berhasil diperbarui']); 
    }

    public function updatePassword(Request $request, $id)
    {
        $this->validate($request, [
            'password' => "required|string|min:5|confirmed",
        ], $this->message());

        $admin = Admin::find($id);
        $admin->update([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(40),
        ]);
        return redirect('admin/admin')->with(['success' => 'Data Admin berhasil diperbarui']); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = Admin::find($id);
        $admin->delete();
        return redirect(route('admin.index'))->with(['success' => 'Data Admin berhasil Dihapus!']);
    }

    public function restore($id)
    {
        $admin = Admin::onlyTrashed()->where('id', $id)->restore();
        return redirect(route('admin.index'))->with(['success' => 'Admin berhasil dikembalikan!']);

    }

    public function force($id)
    {
        $admin = Admin::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect(route('admin.index'))->with(['success' => 'Admin berhasil dihapus permanen!']);
    }
}
