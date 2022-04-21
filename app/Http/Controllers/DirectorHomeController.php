<?php

namespace App\Http\Controllers;

use App\Director;
use Illuminate\Support\Facades\DB;
use App\Transaction;
use App\TrashType;
use App\TrashPrice;
use App\Customer;
use App\Admin;
use App\Earning;
use App\DetailTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DirectorHomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware('auth:director');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
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
        return view('director.home', compact('transactions', 'customers', 'transaction_ontrashed', 'subtotals', 'withdraws'));
    }

    public function admin()
    {
        $admins = Admin::get();
        return view('director.admin', compact('admins'));
    }

    public function director()
    {
        $directors = Director::get();
        return view('director.director', compact('directors'));
    }

    public function customer()
    {
        $customers = Customer::get();
        return view('director.customer', compact('customers'));
    }

    public function trashtype()
    {
        $trashtype = TrashType::get();
        return view('director.trashtype', compact('trashtype'));
    }

    public function trashprice()
    {
        $trashprice = TrashPrice::with('trashtype')->get();
        return view('director.trashprice', compact('trashprice'));
    }

    public function transaction()
    {
        $transactions = Transaction::with('detailtransactions', 'customer', 'admin')->get();
        $subtotals = Transaction::with('customer')->groupBy('customer_id')
                ->select([
                    'transactions.customer_id',
                    DB::raw('sum(transactions.subtotal) AS subtotal'),
                ])
                ->get();
        $withdraws = Earning::with('customer', 'admin')->orderBy('created_at', 'desc')->get();
        $customers = Customer::where('status', 1)->get();
        $transaction_ontrashed = Transaction::onlyTrashed()->get();
        return view('director.transaction', compact('transactions', 'customers', 'transaction_ontrashed', 'subtotals', 'withdraws'));
    }

    public function showTransaction(Request $request, $id)
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
        
        return view('director.show', compact('detail_transactions', 'detail', 'transaction', 'total', 'trashtypes', 'trashprices', 'detail_ontrashed'));
    }

    public function earning()
    {
        $withdraws = Earning::with('customer')->get();
        //dd($withdraws);
        return view('director.earning', compact('withdraws'));
    }
}
