<?php

namespace App\Http\Controllers;

use App\TrashPrice;
use App\TrashType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TrashPriceController extends Controller
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
        $trashtype = TrashType::where('status', '1')->get();
        $trashprice = TrashPrice::with('trashtype')->get();
        $trashprice_ontrashed = TrashPrice::onlyTrashed()->get();
        
        return view('admin.trashprice', compact('trashprice', 'trashtype', 'trashprice_ontrashed'));
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
            'required' => ':attribute harus diisi',
            'min' => ':attribute minimal :min karakter',
            'unique' => ':attribute sudah ada, silahkan ganti dengan yang lain.',
            'regex' => 'Penulisan :attribute tidak sesuai',
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
            'trashtype_id' => "required",
            'name' => "required|string|min:3|unique:trash_prices",
            'description' => "required|string|min:3",
            'price' => "required|regex:/^\d+(\.\d{1,2})?$/",
            'unit' => "required|string",
        ], $this->message());

        $request->request->add(['slug' => $request->name]);

        $input = array([
            'name' => $request->name,
            'description' => $request->description,
            'trashtype_id' => $request->trashtype_id,
            'price' => $request->price,
            'unit' => $request->unit,
            'admin_id' => $request->admin_id,
        ]);

        //dd($input);

        TrashPrice::create([
            'name' => $request->name,
            'description' => $request->description,
            'trashtype_id' => $request->trashtype_id,
            'price' => $request->price,
            'unit' => $request->unit,
            'admin_id' => $request->admin_id,
            'status' => 1,
        ]);
        
        return redirect('admin/trashprice')->with(['success' => 'Sampah berhasil ditambahkan']); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TrashPrice  $trashPrice
     * @return \Illuminate\Http\Response
     */
    public function show(TrashPrice $trashPrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TrashPrice  $trashPrice
     * @return \Illuminate\Http\Response
     */
    public function edit(TrashPrice $trashPrice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TrashPrice  $trashPrice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrashPrice $trashPrice, $id)
    {
        //dd($request->all());
        
        $this->validate($request, [
            'trashtype_id' => "required",
            'name' => "required|string|min:3|unique:trash_prices,name,$id",
            'description' => "required|string|min:3",
            'price' => "required|regex:/^\d+(\.\d{1,2})?$/",
            'unit' => "required|string",
        ], $this->message());

        $trashprice = TrashPrice::find($id);

        $trashprice->update([
            'name' => $request->name,
            'description' => $request->description,
            'trashtype_id' => $request->trashtype_id,
            'price' => $request->price,
            'unit' => $request->unit,
            'admin_id' => $request->admin_id,
            'status' => $request->status,
        ]);
        
        return redirect('admin/trashprice')->with(['success' => 'Kategori sampah berhasil diperbarui']); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TrashPrice  $trashPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrashPrice $trashPrice, $id)
    {
        $trashprice = TrashPrice::find($id);
        $trashprice->delete();
        return redirect(route('trashprice.index'))->with(['success' => 'Sampah berhasil Dihapus!']);
    }

    public function restore($id)
    {
        $trashprice = TrashPrice::onlyTrashed()->where('id', $id)->restore();
        return redirect(route('trashprice.index'))->with(['success' => 'Sampah berhasil dikembalikan!']);

    }

    public function force($id)
    {
        $trashprice = TrashPrice::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect(route('trashprice.index'))->with(['success' => 'Sampah berhasil dihapus permanen!']);
    }
}
