<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\DetailTransaction;
use Illuminate\Support\Facades\DB;
use App\Customer;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $detail = Transaction::with('customer', 'detailtransactions', 'admin')->get();

        $omset = DB::table('transactions')->where('status', 1)->sum('admin_fee');

        /*$omset_bulan = DB::table('transactions')
                        ->join('detail_transactions', function ($join) {
                            $join->on('transactions.id', '=', 'detail_transactions.transaction_id')
                                 ->whereMonth('transactions.created_at', '1');
                        })
                        ->sum('subtotal');
*/
        $omset_bulan = DB::table('transactions')->whereMonth('created_at', now()->month)->where('status', 1)->sum('admin_fee');
        $customer = DB::table('customers')->get();

        return view('admin.home', compact('detail', 'omset_bulan', 'omset', 'customer'));
    }

}
