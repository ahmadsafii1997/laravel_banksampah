<?php

namespace App\Http\Controllers;

use App\TrashType;
use App\TrashPrice;
use App\Transaction;
use App\Customer;
use App\DetailTransaction;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PDF;

class DetailTransactionController extends Controller
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
        //dd($request->transaction_id);
        $transaction = Transaction::with('detailtransactions', 'customer', 'admin')->where('id', $request->transaction_id)->get();
        $trashtypes = TrashType::has('trashprice')->get();
        $trashprices = TrashPrice::with('trashtype')->get();
        //dd($transaction);
            return view('admin.detail_transaction2', compact('transaction', 'trashtypes'));
        /*
        foreach ($transactions as $transaction) {
        }
        */
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DetailTransaction  $detailTransaction
     * @return \Illuminate\Http\Response
     */
    public function show(DetailTransaction $detailTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DetailTransaction  $detailTransaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        dd($request->all());
        $transaction = Transaction::with('detailtransactions')->find($request->transaction_id);
        //dd($transaction);
        $trashtypes = TrashType::with('trashprice')->get();
        $trashprices = TrashPrice::get();
        return view('admin.detail_edit', compact('trashtypes', 'trashprices'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DetailTransaction  $detailTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DetailTransaction $detailTransaction)
    {
        //
    }

    public function print(Request $request)
    {
        $transaction = Transaction::with('customer', 'admin', 'detailtransactions')->where('id', $request->transaction_id)->get();
        $filters = DetailTransaction::with('transaction')->where('transaction_id', $request->transaction_id)->get();

        $total_admin_fee = $filters->sum('admin_fee');
        $total = $filters->sum('subtotal');
        //dd($transaction, $filters);
        if($filters->count() != '0'){
            $pdf = PDF::loadView('admin.filters2', compact('transaction', 'filters', 'total_admin_fee', 'total'))->setPaper('a4', 'landscape');
                return $pdf->stream();
        }
        return redirect('admin/transaction')->with(['error' => 'Data tidak ditemukan, mohon periksa kembali.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DetailTransaction  $detailTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $transaction_id = $request->transaction_id;
        $detailTransaction = DetailTransaction::with('transaction')->find($id);
        $detailTransaction->update([
            'status' => '0',
        ]);
        $detailTransaction->delete();
        
        $transaction = Transaction::has('detailtransactions')->where('id', $transaction_id)->get();
        if ($transaction->count() == 0) {
            $trans = Transaction::find($transaction_id);
            $trans->update([
                'admin_fee' => '0',
                'subtotal' => '0',
                'status' => '0',
            ]);

            $customer = Customer::find($request->customer_id);
            $customer->update([
                'earning' => '0',
            ]);
            return redirect(route('transaction.index'))->with(['success' => 'Detail transaksi berhasil Dihapus!']);
        }

        $trans = Transaction::find($transaction_id);
        $trans->update([
            'admin_fee' => $detailTransaction->sum('admin_fee'),
            'subtotal' => $detailTransaction->sum('subtotal'),
        ]);

        $customer = Customer::find($request->customer_id);
        $customer->update([
            'earning' => $detailTransaction->sum('subtotal'),
        ]);
        return redirect(route('transaction.show', $request->transaction_id))->with(['success' => 'Detail transaksi berhasil Dihapus!']);
    }

    public function restore($id)
    {
        //$detailTransaction = DetailTransaction::withTrashed()->find($id)->restore();
        $detailtransactions = DetailTransaction::withTrashed()->find($id);
        
        $detailtransactions->update([
           'status' => 1,
        ]);

        $restore = $detailtransactions->restore();
        $subtotal = DetailTransaction::where('transaction_id', $detailtransactions->transaction_id)->sum('subtotal');
        $admin_fee = DetailTransaction::where('transaction_id', $detailtransactions->transaction_id)->sum('admin_fee');
        $transaction = Transaction::find($detailtransactions->transaction_id);
        $transaction->update([
            'admin_fee' => $admin_fee,
            'subtotal' => $subtotal,
            'status' => 1,
        ]);

        $earning = Customer::find($transaction->customer_id);
        $earning->update([
            'earning' => $subtotal,
        ]);

        return redirect(route('transaction.index'))->with(['success' => 'Detail transaksi berhasil Dikembalikan!']);
    }

    public function force($id)
    {
        $detailTransaction = DetailTransaction::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect(route('transaction.index'))->with(['success' => 'Detail transaksi berhasil dihapus permanen!']);
    }
}
