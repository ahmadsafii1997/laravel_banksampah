<?php

namespace App\Http\Controllers;

use App\TrashType;
use Transaction;
use App\DetailTransaction;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TransController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trashtypes = TrashType::has('trashprice')->get();
        //$trashtypes = DB::table('trash_types')->pluck('name', 'id');
        return view('admin.transaction2', compact('trashtypes'));
    }

    public function trashPrice($id)
    {
        $trashprices = DB::table("trash_prices")->where("trashtype_id",$id)->pluck("name","id");
        return json_encode($trashprices);
    }

    public function getPrice($id)
    {
        $price = DB::table("trash_prices")->where("id",$id)->pluck("price","id");
        //dd($price);
        return json_encode($price);
    }

    public function message()
    {
        return $message = ([
            'required' => ':attribute wajib diisi',
            'min' => ':attribute minimal :min karakter',
            'unique' => ':attribute sudah ada, silahkan ganti dengan yang lain.',
        ]);
    }

    public function post(Request $request)
    {
        $detail = DetailTransaction::create($request->all());
        dd($detail);
        return redirect('admin/outlet')->with(['success' => 'Outlet berhasil ditambahkan']); 
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
