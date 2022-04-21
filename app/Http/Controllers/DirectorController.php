<?php

namespace App\Http\Controllers;

use App\Director;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DirectorController extends Controller
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
    public function index()
    {
        $directors = Director::get();
        $director_count = $directors->count();
        $director_ontrashed = Director::onlyTrashed()->get();
        return view('admin.director', compact('directors', 'director_ontrashed', 'director_count'));
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
            'password.*confirmed' => 'Kata sandi tidak sesuai.', 
            'min' => ':attribute minimal :min karakter.',
            'max' => ':attribute maksimal 255 karakter.',
            'unique' => ':attribute sudah ada, silahkan ganti dengan yang lain.',
            'email' => 'penulisan :attribute tidak sesuai.',
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
            'name' => "required|string|min:3|unique:directors",
            'email' => "required|string|email|max:255|unique:directors",
            'password' => "required|string|min:5",
        ], $this->message());

        Director::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        return redirect('admin/director')->with(['success' => 'Direktur berhasil ditambahkan']); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($request->all());
        $this->validate($request, [
            'name' => "required|string|min:3|unique:directors,name,$id",
            'email' => "required|string|email|max:255|unique:directors,email,$id",
        ], $this->message());

        $director = Director::find($id);
        
        $director->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ]);
        
        return redirect('admin/director')->with(['success' => 'Data Direktur berhasil diperbarui']); 
    }

    public function updatePassword(Request $request, $id)
    {
        $this->validate($request, [
            'password' => "required|string|min:5|confirmed",
        ], $this->message());

        $director = Director::find($id);
        $director->update([
            'password' => Hash::make($request->password),
        ]);
        return redirect('admin/director')->with(['success' => 'Data Direktur berhasil diperbarui']); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $directors = Director::count();
        //dd($directors);
        $director = Director::find($id);
        $director->delete();
        return redirect(route('director.index'))->with(['success' => 'Data Direktur berhasil Dihapus!']);
    }

    public function restore($id)
    {
        $director = Director::onlyTrashed()->where('id', $id)->restore();
        return redirect(route('director.index'))->with(['success' => 'Direktur berhasil dikembalikan!']);

    }

    public function force($id)
    {
        $director = Director::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect(route('director.index'))->with(['success' => 'Direktur berhasil dihapus permanen!']);
    }
}
