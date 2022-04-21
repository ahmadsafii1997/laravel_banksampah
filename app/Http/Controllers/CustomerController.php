<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerController extends Controller
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
        $customers = Customer::orderBy('name', 'desc')->get();
        $customer_ontrashed = Customer::onlyTrashed()->get();
        //dd($customers);

        return view('admin.customer', compact('customers', 'customer_ontrashed'));
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
    public function message()
    {
        return $message = ([
            //'password.*min' => 'Kata sandi minimal :min karakter.', 
            'required' => ':attribute harus diisi.',
            'min' => ':attribute minimal :min karakter.',
            'unique' => ':attribute sudah ada, silahkan ganti dengan yang lain.',
            'digits_between' => 'Penulisan :attribute tidak sesuai.',
            'phone.*numeric' => 'Penulisan nomor telepon tidak sesuai.',
            'nik.*numeric' => 'Penulisan NIK tidak sesuai.',
        ]);
    }

    public function store(Request $request)
    {
        if ($request->phone != null) {
            $this->validate($request, [
                'phone' => "numeric|digits_between:10,13|unique:customers",
            ], $this->message());
        }
        $this->validate($request, [
            //'nik' => "required|numeric|digits_between:12,17|unique:customers",
            'nik' => "unique:customers",
            'name' => "required|string|min:3|unique:customers",
            'username' => "required|string|min:3|unique:customers",
            'address' => "required|string|min:3",
        ], $this->message());

        $nik = random_int(111111111111, 99999999999999999);
  
        //dd($nik);

        $customer = Customer::create([
            //'nik' => $request->nik,
            'nik' => $nik,
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->username),
            'address' => $request->address,
            'phone' => $request->phone,
            'status' => '1',
            'point' => '0',
        ]);
        
        return redirect('admin/customer')->with(['success' => 'Nasabah berhasil ditambahkan']); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::where('id', $id)->get();
        //return $customer;
        return view('admin.customer_show', compact('customer'));
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
        if ($request->phone != null) {
            $this->validate($request, [
            'phone' => "numeric|digits_between:10,13|unique:customers,phone,$id",
            ], $this->message());
        }

        $this->validate($request, [
            //'nik' => "required|numeric|digits_between:12,15|unique:customers,nik,$id",
            'nik' => "unique:customers,nik,$id",
            'name' => "required|string|min:3|unique:customers,name,$id",
            'username' => "required|string|min:3|unique:customers,name,$id",
            'address' => "required|string|min:3",
        ], $this->message());

        $customer = Customer::find($id);
        
        $customer->update([
            'nik' => $request->nik,
            'name' => $request->name,
            'username' => $request->username,
            'address' => $request->address,
            'phone' => $request->phone,
            'status' => $request->status,
            'point' => $request->point,
        ]);
        
        return redirect('admin/customer')->with(['success' => 'Data Nasabah berhasil diperbarui']); 
    }

    public function updatePassword(Request $request, $id)
    {
        $this->validate($request, [
            'password' => "required|string|min:5|confirmed",
        ], $this->message());

        $customer = Customer::find($id);
        $customer->update([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(40),
        ]);
        return redirect('admin/customer')->with(['success' => 'Data Nasabah berhasil diperbarui']); 

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->delete();
        return redirect(route('customer.index'))->with(['success' => 'Data Nasabah berhasil Dihapus!']);
    }

    public function restore(Request $request, $id)
    {
        $customer = Customer::withTrashed()
                ->where('id', $id)
                ->restore();
        return redirect(route('customer.index'))->with(['success' => 'Data Nasabah berhasil dikembalikan!']);

    }

    public function force($id)
    {
        $customer = Customer::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect(route('customer.index'))->with(['success' => 'Data Nasabah berhasil dihapus permanen!']);
    }
}
