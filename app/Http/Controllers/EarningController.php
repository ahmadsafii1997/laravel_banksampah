<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\DetailTransaction;
use Illuminate\Support\Facades\Auth;
use App\Customer;
use Illuminate\Support\Facades\Hash;
use App\Admin;
use App\Earning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use PDF;

class EarningController extends Controller
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
    public function index(Request $request)
    {
        $transactions = Transaction::with('customer', 'admin', 'detailtransactions')->get();
        $subtotals = Transaction::with('customer')->groupBy('customer_id')
                ->select([
                    'transactions.customer_id',
                    DB::raw('sum(transactions.subtotal) AS subtotal'),
                ])
                ->get();
        $withdraws = Earning::with('customer', 'admin')->orderBy('created_at', 'desc')->get();
        $customers = Customer::where('status', 1)->get();
        $transaction_ontrashed = Transaction::onlyTrashed()->get();
        return view('admin.earning', compact('transactions', 'customers', 'transaction_ontrashed', 'subtotals', 'withdraws'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getStates($id)
    {
        $price = DB::table("transactions")->where("customer_id",$id)->pluck("subtotal","id");
        //dd($price);
        return json_encode($price);
    }

    public function earning()
    {
        $transactions = Transaction::with('customer', 'admin', 'detailtransactions')->get();
        $subtotals = Transaction::with('customer')->groupBy('customer_id')
                ->select([
                    'transactions.customer_id',
                    DB::raw('sum(transactions.subtotal) AS subtotal'),
                ])
                ->get();
        $customers = Customer::where('status', 1)->get();
        $transaction_ontrashed = Transaction::onlyTrashed()->get();
        return view('admin.earning', compact('transactions', 'customers', 'transaction_ontrashed', 'subtotals'));
    }

    public function message()
    {
        return $message = ([
            'required' => ':attribute harus diisi.',
        ]);
    }

    public function withdraw($id, Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'earning' => "required",
            'amount' => "required|regex:/^\d+(\.\d{1,2})?$/",
            'password' => "required|string",
        ], $this->message());

        if (Hash::check($request->password, Auth::user()->password)) {
            $earning_before = $request->earning;
            $amount = $request->amount;
            $earning_after = $earning_before - $amount;
            $customer = Customer::find($request->customer_id);
            $customer->update([
                'earning' => $earning_after,
            ]);

            $earning = Earning::create([
                'customer_id' => $request->customer_id,
                'admin_id' => Auth::user()->id,
                'amount' => $request->amount,
                'status' => 1,
            ]);
            return redirect('admin/earning')->with(['success' => 'Penarikan saldo berhasil']);
        }else{
            return redirect('admin/earning')->withInput()->with(['error' => 'Kata Sandi tidak sesuai']);
        }
    }

    public function print(Request $request)
    {
        if($request->jenis == '1')
        {
            $earnings = Customer::get();
            
            $pdf = PDF::loadView('admin.earning_print', compact('earnings'));
            return $pdf->stream('earning.pdf', array("Attachment" => false));
            
        }
        else
        {
            echo "Saldo Keluar";
        }

    }

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
    public function withdrawUpdate(Request $request, $id)
    {
        //dd($request->all());
        $earning = Earning::find($id);
        //dd($earning);
        $earning->update([
            'status' => $request->status,
        ]);

        if ($request->status == 1) {
            return redirect('admin/earning')->with(['success', 'Penarikan saldo berhasil disetujui']);
        }else{
            return redirect('admin/earning')->with(['success', 'Penarikan saldo tidak disetujui']);
        }
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
