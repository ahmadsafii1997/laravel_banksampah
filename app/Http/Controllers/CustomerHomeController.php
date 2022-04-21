<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Support\Facades\DB;
use App\Transaction;
use Illuminate\Support\Facades\Hash;
use App\Earning;
use App\TrashType;
use App\TrashPrice;
use App\DetailTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CustomerHomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware('auth:customer');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        $earnings = Customer::find(Auth::user()->id);
        $withdraws = Earning::where('customer_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        //return view('customer.earning', compact('earnings', 'withdraws'));
        $detail = Transaction::with('customer', 'detailtransactions', 'admin')->where('customer_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();

        $sub_total_transaksi = DB::table('detail_transactions')
                ->select('transaction_id', DB::raw('SUM(subtotal) as subtotal'))
                ->groupBy('transaction_id')
                //->havingRaw('SUM(price) > ?', [2500])
                ->get();
        $earning = Customer::where('id', Auth::user()->id)->sum('earning');
        //dd($earning);
        return view('customer.home', compact('detail', 'sub_total_transaksi', 'earning', 'earnings'));
    }

    public function transactionShow($id, Request $request)
    {
        $detailtransactions = DetailTransaction::with('transaction', 'trashprice', 'trashtype')
                            ->where('transaction_id', $id)
                            ->get();
        foreach ($detailtransactions as $detail) {
            $customer_id = $detail->transaction->customer_id;
            $transaction_id = $detail->transaction->id;
        }
        $total = $detailtransactions->sum('subtotal');
        
        return view('customer.transactionShow', compact('detailtransactions', 'total'));

    }

    public function earning(Request $request)
    {
        $earnings = Customer::find(Auth::user()->id);
        $withdraws = Earning::where('customer_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('customer.earning', compact('earnings', 'withdraws'));
    }

    public function message()
    {
        return $message = ([
            'required' => ':attribute harus diisi.',
        ]);
    }

    public function withdraw($id, Request $request)
    {
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
                'admin_id' => 1,
                'amount' => $request->amount,
                'status' => 0,
            ]);
            return redirect('customer/earning')->with(['success' => 'Penarikan saldo berhasil']);
        }else{
            return redirect('customer/earning')->withInput()->with(['error' => 'Kata Sandi tidak sesuai']);
        }
    }

    public function trashtype()
    {
        $trashtype = TrashType::get();
        return view('customer.trashtype', compact('trashtype'));
    }

    public function trashprice()
    {
        $trashprice = TrashPrice::with('trashtype')->get();
        return view('customer.trashprice', compact('trashprice'));
    }
}
