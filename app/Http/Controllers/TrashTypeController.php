<?php

namespace App\Http\Controllers;

use App\TrashType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TrashTypeController extends Controller
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
        $trashtype = TrashType::get();
        $parents = TrashType::withCount('trashprice')->get();
        //dd($parent);
        $trashtype_ontrashed = Trashtype::onlyTrashed()->get();
        return view('admin.trashtype', compact('trashtype', 'parents', 'trashtype_ontrashed'));
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
            'required' => ':attribute wajib diisi',
            'min' => ':attribute minimal :min karakter',
            'unique' => ':attribute sudah ada, silahkan ganti dengan yang lain.',
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
            'name' => "required|string|min:3|unique:trash_types",
            'description' => "required|string|min:3",
        ], $this->message());

        TrashType::create([
                'name' => $request->name, 
                'description' => $request->description, 
                'admin_id' => $request->admin_id,
                'status' => 1,
            ]);
        
        return redirect('admin/trashtype')->with(['success' => 'Kategori sampah berhasil ditambahkan']); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TrashType  $trashType
     * @return \Illuminate\Http\Response
     */
    public function show(TrashType $trashType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TrashType  $trashType
     * @return \Illuminate\Http\Response
     */
    public function edit(TrashType $trashType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TrashType  $trashType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => "required|string|min:3|unique:trash_types,name,$id",
            'description' => "required|string|min:3",
        ], $this->message());


        $trashtype = TrashType::find($id);

        $trashtype->update([
            'name' => $request->name, 
            'description' => $request->description, 
            'admin_id' => $request->admin_id,
            'status' => $request->status,
        ]);
        
        return redirect('admin/trashtype')->with(['success' => 'Kategori sampah berhasil diperbarui']); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TrashType  $trashType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $trashtype = TrashType::withCount('trashprice')->find($id);
        if($trashtype->trashprice_count == 0 )
        {
            $trashtype->delete();
           return redirect(route('trashtype.index'))->with(['success' => 'Kategori Dihapus!']);
        }
        return redirect(route('trashtype.index'))->with(['error' => 'Kategori ini memiliki anak kategori!']);
    }

    public function restore($id)
    {
        $trashtype = TrashType::onlyTrashed()->where('id', $id)->restore();
        return redirect(route('trashtype.index'))->with(['success' => 'Kategori berhasil dikembalikan!']);

    }

    public function force($id)
    {
        $trashtype = TrashType::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect(route('trashtype.index'))->with(['success' => 'Kategori berhasil dihapus permanen!']);
    }
}
