<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\DetailTransaction;
use App\Customer;
use App\Admin;
use App\TrashType;
use App\TrashPrice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use PDF;

class TransactionController extends Controller
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
        $transactions = Transaction::with('customer', 'admin', 'detailtransactions')->get();
        $customers = Customer::where('status', 1)->orderBy('name', 'asc')->get();
        $transaction_ontrashed = Transaction::onlyTrashed()->get();
        $code = 'T_'. date('Ymd_His');
        return view('admin.transaction', compact('transactions', 'customers', 'transaction_ontrashed', 'code'));
        //
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
            'required' => ':attribute harus diisi',
            'min' => ':attribute minimal :min karakter',
            'unique' => ':attribute sudah ada, silahkan ganti dengan yang lain.',
            'regex' => 'Penulisan :attribute tidak sesuai',
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => "required|string|min:3|unique:transactions",
            //'amount' => "regex:/^\d+(\.\d{1,2})?$/",
            'customer_id' => "required",
            'admin_id' => "required",
        ], $this->message());

        $trashtypes = TrashType::has('trashprice')->get();

        $trashprices = TrashPrice::with('trashtype')->get();

        //dd($request->all());
        $transaction = Transaction::create([
            'code' => $request->code, 
            'customer_id' => $request->customer_id,
            'admin_id' => $request->admin_id,
            'amount' => '0', 
            'status' => 0,
        ]);

        $transactions = Transaction::where('code', $request->code)->get();
        foreach ($transactions as $transaction) {
            return view('admin.transaction2', compact('transactions', 'trashtypes'));
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $detail_transactions = DetailTransaction::with('transaction', 'trashtype', 'trashprice')->where('transaction_id',$id)->get();
        $trashtypes = TrashType::has('trashprice')->get();
        $trashprices = TrashPrice::with('trashtype')->get();
        $detail_ontrashed = DetailTransaction::onlyTrashed()->with('transaction')->get();

        foreach ($detail_transactions as $detail) {
            $customer_id = $detail->transaction->customer_id;
            $transaction_id = $detail->transaction->id;
        }
        $total = $detail_transactions->sum('subtotal');
        $transaction = Transaction::with('customer')->where('id', $id)->get();
        
        return view('admin.show', compact('detail_transactions', 'detail', 'transaction', 'total', 'trashtypes', 'trashprices', 'detail_ontrashed'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code' => "required|string|min:3|unique:transactions,code,$id",
            'amount' => "required|regex:/^\d+(\.\d{1,2})?$/",
            'customer_id' => "required",
            'admin_id' => "required",
        ], $this->message());

        $transaction = Transaction::find($id);

        $transaction->update([
            'code' => $request->code, 
            'customer_id' => $request->customer_id,
            'admin_id' => $request->admin_id,
            'amount' => $request->amount, 
            'status' => $request->status,
        ]);

        return redirect('admin/transaction')->with(['success' => 'Data Transaksi berhasil diperbarui']); 
    }

    public function postDetail(Request $request)
    {
        foreach ($request->addmore as $key => $value) {
            $subtotal = ($value['price'] * $value['qty']);
            $biaya_admin = $subtotal * 0.1;
            $total = $subtotal - $biaya_admin;
            $detail = DetailTransaction::create([
                'transaction_id' => $value['transaction_id'],
                'trashprice_id' => $value['trashprice_id'],
                'trashtype_id' => $value['trashtype_id'],
                'qty' => $value['qty'],
                'price' => $value['price'],
                'admin_fee' => $biaya_admin,
                'subtotal' => $total,
                'status' => 1,
            ]);
        }

        $transaction = Transaction::with('detailtransactions', 'customer')->find($detail->transaction_id);
        $subtotal = $transaction->detailtransactions->sum('subtotal');
        
        $update = $transaction->update([
            'admin_fee' => $transaction->detailtransactions->sum('admin_fee'),
            'subtotal' => $subtotal,
            'status' => 1,
        ]);

        //$subtotals = Transaction::where('customer_id', $transaction->customer_id)->sum('subtotal');

        $customer = Customer::find($transaction->customer_id);
        if ($customer->earning != null) {
            $earning_before = $customer->earning;
            $customer->update([
                'earning' => ($subtotal + $earning_before),
            ]);
            return redirect('admin/transaction')->with(['success' => 'data berhasil disimpan']);
        }
        $customer->update([
            'earning' => ($subtotal),
        ]);
        return redirect('admin/transaction')->with(['success' => 'data berhasil disimpan']);
    }

    public function filter(Request $request)
    {
        $customer_print = $request->input('customer_print');
        $month_print = $request->input('month_print');
        $year_print = $request->input('year_print');

        $filters = collect(Transaction::with('detailtransactions', 'admin', 'customer')
            ->where('status', 1)
            ->when($customer_print, function ($query) use ($customer_print) {
                return $query->where('customer_id', $customer_print);
            })
            ->when($month_print, function ($query) use ($month_print) {
                return $query->whereMonth('created_at', $month_print);
            })
            ->when($year_print, function ($query) use ($year_print) {
                return $query->whereYear('created_at', $year_print);
            })
            ->get());

        $total_admin_fee = $filters->sum('admin_fee');
        $total = $filters->sum('subtotal');

        if($filters->count() != '0'){
            $pdf = PDF::loadView('admin.filters', compact('filters', 'total_admin_fee', 'total'))->setPaper('f4', 'portrait');
            return $pdf->stream();
        }
        return redirect('admin/transaction')->with(['error' => 'Data tidak ditemukan, mohon periksa kembali.']);
    }

    public function getStates($id)
    {
        $price = DB::table("transactions")->where("customer_id",$id)->pluck("subtotal","id");
        //dd($price);
        return json_encode($price);
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::find($id);
        $customer_id = $transaction->customer_id;
        $transaction->update([
            'status' => 0,
        ]);
        $transaction->delete();

        $subtotals = Transaction::where('customer_id', $customer_id)->sum('subtotal');
        //dd($subtotals);
        $customer = Customer::find($customer_id);
        $customer->update([
            'earning' => $subtotals,
        ]);
        
        return redirect(route('transaction.index'))->with(['success' => 'Data transaksi berhasil Dihapus!']);
    }

    public function restore($id)
    {
        $transactions = Transaction::withTrashed()->where('id', $id)->get();

        foreach ($transactions as $transaction) {
            $customer_id = $transaction->customer_id;

            $transaction->update([
                'status' => 1,
            ]);
            $restore = $transaction->restore();
            
            if ($restore == true) {
                $subtotals = Transaction::where('customer_id', $customer_id)->sum('subtotal');

                $customer = Customer::find($customer_id);
                $customer->update([
                    'earning' => ($subtotals),
                ]);
                
                $details = DetailTransaction::withTrashed()->where('transaction_id', $id)->get();
                foreach ($details as $detail) {
                    $detail->update([
                        'status' => 1,
                    ]);
                    $detail->restore();
                }
                
                return redirect(route('transaction.index'))->with(['success' => 'Data transaksi berhasil Dikembalikan!']);
            }
            
        }

        return redirect(route('transaction.index'))->with(['success' => 'Data transaksi berhasil Dikembalikan!']);
    }

    public function force($id)
    {
        $transaction = Transaction::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect(route('transaction.index'))->with(['success' => 'Data transaksi berhasil dihapus permanen!']);
    }
}
