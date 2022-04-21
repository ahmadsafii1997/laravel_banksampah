<!-- FUNGSI EXTENDS DIGUNAKAN UNTUK ME-LOAD MASTER LAYOUTS YANG ADA, KARENA INI ADALAH HALAMAN HOME MAKA KITA ME-LOAD LAYOUTS ADMIN.BLADE.PHP -->
<!-- KETIKA MELOAD FILE BLADE, MAKA EKSTENSI .BLADE.PHP TIDAK PERLU DITULISKAN -->
@extends('admin.layouts.layout')

<!-- TAG YANG DIAPIT OLEH SECTION('TITLE') AKAN ME-REPLACE @YIELD('TITLE') PADA MASTER LAYOUTS -->
@section('title')
    <title>Dashboard</title>
@endsection

<!-- TAG YANG DIAPIT OLEH SECTION('CONTENT') AKAN ME-REPLACE @YIELD('CONTENT') PADA MASTER LAYOUTS -->
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Beranda</li>
    </ol>
    <div class="container-fluid content mt-3">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-xl-4 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-one">
                                    <div class="stat-icon dib"><i class="fa fa-money text-success border-success"></i></div>
                                    <div class="stat-content dib">
                                        <div class="stat-text">Total Profit</div>
                                        <div class="stat-digit">Rp. {{ number_format($omset)}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/.col-->

                    <div class="col-xl-4 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-one">
                                    <div class="stat-icon dib"><i class="fa fa-money text-success border-success"></i></div>
                                    <div class="stat-content dib">
                                        <div class="stat-text">Omset Bulan ini</div>
                                        <div class="stat-digit">Rp. {{ number_format($omset_bulan) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/.col-->

                    <div class="col-xl-4 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-one">
                                    <div class="stat-icon dib"><i class="fa fa-users text-success border-success"></i></div>
                                    <div class="stat-content dib">
                                        <div class="stat-text">Jumlah Nasabah</div>
                                        <div class="stat-digit">{{ $customer->count() }} Orang</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/.col-->
                </div>
                <div class="col-md-12 animated fadeIn">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Transaksi</h4>
                        </div>
                        <div class="card-body">
                            <div class="custom-tab">                                
                                <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="main-nav" role="tabpanel" aria-labelledby="main-nav-tab">
                                        @if($detail->count() > 0)
                                        <table id="bootstrap-data-table" class="table table-striped">
                                            <thead>
                                              <tr>
                                                <th>#</th>
                                                <th>Kode</th>
                                                <th>Nasabah</th>
                                                <th>Tanggal</th>
                                                <th>Total</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = 1;
                                                @endphp
                                                @foreach($detail as $value)
                                                <tr>
                                                    <td>{{ $i++ }}.</td>
                                                    <td><span class="badge badge-primary">{{$value->code}}</span></td>
                                                    <td>{{ ucfirst($value->customer->name)}}</td>
                                                    <td>{{ $value->created_at->translatedFormat('d F Y')}}</td>
                                                    @php
                                                    {{$subtotal = $value->detailtransactions->sum('subtotal');}}
                                                    @endphp
                                                    <td><span class="badge badge-primary">Rp. {{ number_format($subtotal) }}</span></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @else
                                        <div class="sufee-alert alert with-close alert-secondary alert-dismissible fade show" id="alerts">
                                                Belum ada transaksi
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection