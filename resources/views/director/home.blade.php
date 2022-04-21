<!-- FUNGSI EXTENDS DIGUNAKAN UNTUK ME-LOAD MASTER LAYOUTS YANG ADA, KARENA INI ADALAH HALAMAN HOME MAKA KITA ME-LOAD LAYOUTS ADMIN.BLADE.PHP -->
<!-- KETIKA MELOAD FILE BLADE, MAKA EKSTENSI .BLADE.PHP TIDAK PERLU DITULISKAN -->
@extends('admin.layouts.director_layout')

<!-- TAG YANG DIAPIT OLEH SECTION('TITLE') AKAN ME-REPLACE @YIELD('TITLE') PADA MASTER LAYOUTS -->
@section('title')
    <title>Beranda | Direktur</title>
@endsection

<!-- TAG YANG DIAPIT OLEH SECTION('CONTENT') AKAN ME-REPLACE @YIELD('CONTENT') PADA MASTER LAYOUTS -->
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Beranda</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
            <div class="col-xl-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-one">
                                <div class="stat-icon dib"><i class="fa fa-money text-success border-success"></i></div>
                                <div class="stat-content dib">
                                    <div class="stat-text">Total Saldo Semua Nasabah</div>
                                    <div class="stat-digit">Rp.{{ number_format($transactions->sum('subtotal'))}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/.col-->

                <div class="col-xl-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-one">
                                <div class="stat-icon dib"><i class="fa fa-money text-success border-success"></i></div>
                                <div class="stat-content dib">
                                    <div class="stat-text">Sisa Saldo Nasabah</div>
                                    <div class="stat-digit">Rp.{{ number_format($customers->sum('earning'))}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/.col-->

                <div class="col-xl-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-one">
                                <div class="stat-icon dib"><i class="fa fa-money text-success border-success"></i></div>
                                <div class="stat-content dib">
                                    <div class="stat-text">Omset Yang Didapat</div>
                                    <div class="stat-digit">Rp.{{ number_format($transactions->sum('admin_fee'))}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/.col-->

                <div class="col-xl-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-one">
                                <div class="stat-icon dib"><i class="fa fa-money text-success border-success"></i></div>
                                <div class="stat-content dib">
                                    <div class="stat-text">Saldo Yang Ditarik</div>
                                    <div class="stat-digit">Rp.{{ number_format($withdraws->sum('amount'))}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/.col-->  
            </div>
        </div>
    </div>
</main>
@endsection