<!-- FUNGSI EXTENDS DIGUNAKAN UNTUK ME-LOAD MASTER LAYOUTS YANG ADA, KARENA INI ADALAH HALAMAN HOME MAKA KITA ME-LOAD LAYOUTS ADMIN.BLADE.PHP -->
<!-- KETIKA MELOAD FILE BLADE, MAKA EKSTENSI .BLADE.PHP TIDAK PERLU DITULISKAN -->
@extends('admin.layouts.layout')

<!-- TAG YANG DIAPIT OLEH SECTION('TITLE') AKAN ME-REPLACE @YIELD('TITLE') PADA MASTER LAYOUTS -->
@section('title')
    <title>Dashboard</title>

    <style type="text/css">
      .body {
        margin: 0px;
        padding: 0px;
        font-size: 2px;
        font-weight: 300;
        font-variant: normal;
    }
    </style>
@endsection

<!-- TAG YANG DIAPIT OLEH SECTION('CONTENT') AKAN ME-REPLACE @YIELD('CONTENT') PADA MASTER LAYOUTS -->
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Transaksi</li>
    </ol>
    <div class="container-fluid content mt-3">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <!-- ALERT -->
                    @if (count($errors) > 0)
                        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show" id="alerts">
                            <span class="badge badge-pill badge-danger">Gagal</span>
                                {{ 'Data gagal disimpan, mohon periksa' }}
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                      <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show" id="alerts">
                            <span class="badge badge-pill badge-danger">Gagal</span>
                                {{ $message }}
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if ($message = Session::get('success'))
                      <div class="sufee-alert alert with-close alert-success alert-dismissible fade show" id="alerts">
                            <span class="badge badge-pill badge-success">Berhasil</span>
                                {{ $message }}
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <!-- END ALERT -->
                  </div>

                  <div class="content mt-3">
                    <div class="animated fadeIn">
                        <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                      <div class="float-left">
                                          <strong class="card-title" v-if="headerText">Data Transaksi</strong>
                                      </div>
                                      <div class="float-right">
                                          <strong class="card-title">
                                              <nav>
                                                  <div class="nav nav-pills" id="nav-tab" role="tablist">
                                                      <a class="nav-item nav-link active" id="main-nav-tab" data-toggle="tab" href="#main-nav" role="tab" aria-controls="main-nav" aria-selected="true"><i class="fa fa-table"></i></a>
                                                      <a class="nav-item nav-link" id="custom-nav-profile-tab" data-toggle="tab" href="#custom-nav-profile" role="tab" aria-controls="custom-nav-profile" aria-selected="false"><i class="fa fa-plus"></i></a>
                                                      
                                                      <a class="nav-item nav-link" id="custom-nav-print-tab" data-toggle="tab" href="#custom-nav-print" role="tab" aria-controls="custom-nav-print" aria-selected="false"><i class="fa fa-print"></i></a>
                                                      <a class="nav-item nav-link" id="custom-nav-contact-tab" data-toggle="tab" href="#custom-nav-contact" role="tab" aria-controls="custom-nav-contact" aria-selected="false"><i class="fa fa-trash"></i></a>
                                                  </div>
                                              </nav>
                                          </strong>
                                      </div>
                                  </div>
                                <div class="card-body">
                                  <div class="custom-tab">                                
                                    <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="main-nav" role="tabpanel" aria-labelledby="main-nav-tab">
                                            <!--<table id="bootstrap-data-table" class="table table-striped">-->
                                              <table id="bootstrap-data-table" class="table table-striped dt-responsive nowrap" style="width:100%">
                                                <thead>
                                                  <tr>
                                                    <th>#</th>
                                                    <th>Kode</th>
                                                    <th>Nama Nasabah</th>
                                                    <th>Total</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  @php
                                                    $i = 1;
                                                  @endphp
                                                  @foreach($transactions as $val)
                                                  <tr>
                                                    <td>{{ $i++ }}.</td>
                                                    <td><a href="{{ route('transaction.show', $val->id)}}"><span class="badge badge-primary">{{ ucfirst($val->code )}}</span></a></td>
                                                    <td>{{ ucfirst($val->customer->name )}}</td>
                                                    @php
                                                    {{$subtotal = $val->detailtransactions->sum('subtotal');}}
                                                    {{$admin_fee = $val->detailtransactions->sum('admin_fee');}}
                                                    @endphp
                                                    <td>Rp. {{ number_format($subtotal) }}</td>
                                                    @if($val->status == 1)
                                                    <td><span class="badge badge-primary">Aktif</span></td>
                                                    @else
                                                    <td><span class="badge badge-secondary">Tidak Aktif</span></td>
                                                    @endif
                                                    <td>
                                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{$val->id}}"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                  </tr>
                                                  @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="custom-nav-profile" role="tabpanel" aria-labelledby="custom-nav-profile-tab">
                                            <form action="{{route('transaction.store')}}" method="post" novalidate="novalidate">
                                                @csrf
                                                <div class="form-group">
                                                  <label for="code" class="control-label mb-1">Kode Transaksi</label>
                                                  <select name="code" class="form-control @error('code') is-invalid @enderror" readonly>
                                                    <option value="{{$code}}">{{$code}}</option>
                                                  </select>
                                                </div>

                                                <div class="form-group">
                                                  <label for="customer_id" class="control-label mb-1">Nama Nasabah</label>
                                                    <select name="customer_id" class="form-control @error('customer_id') is-invalid @enderror" required>
                                                      <option value="">-- Pilih --</option>
                                                      @foreach($customers as $customer)
                                                        @if(old('customer_id') == $customer->id)
                                                        <option value="{{ $customer->id }}" selected>{{ ucfirst($customer->name) }}</option>
                                                        @else
                                                        <option value="{{ $customer->id }}">{{ ucfirst($customer->name) }}</option>
                                                        @endif
                                                      @endforeach
                                                    </select>
                                                </div>
                                                @error('customer_id')
                                                  <div class="alert alert-danger" role="alert">
                                                      {{ $message }}
                                                  </div>
                                                @enderror

                                                <div class="form-group">
                                                  <label for="admin_id" class="control-label mb-1">Nama Admin</label>
                                                    
                                                  <select name="admin_id" class="form-control @error('admin_id') is-invalid @enderror" readonly>
                                                    <option value="{{Auth::user()->id}}">{{Auth::user()->name}}</option>
                                                  </select>
                                                </div>

                                              <div>
                                                  <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                                      <span id="payment-button-amount">Simpan</span>
                                                  </button>
                                              </div>
                                          </form>
                                        </div>

                                        <div class="tab-pane fade" id="custom-nav-print" role="tabpanel" aria-labelledby="custom-nav-print-tab">
                                            <form action="{{route('transaction.filter')}}" method="post" novalidate="novalidate">
                                                @csrf
                                                <div class="form-group">
                                                  <select class="form-control @error('customer_print') is-invalid @enderror" name="customer_print">
                                                    <option value="">-- Pilih Nama--</option>
                                                      @foreach($customers as $customer)
                                                        @if(old('customer_id') == $customer->id)
                                                        <option value="{{ $customer->id }}" selected>{{ ucfirst($customer->name) }}</option>
                                                        @else
                                                        <option value="{{ $customer->id }}">{{ ucfirst($customer->name) }}</option>
                                                        @endif
                                                      @endforeach
                                                  </select>
                                                </div>

                                                @error('customer_print')
                                                  <div class="alert alert-danger" role="alert">
                                                      {{ $message }}
                                                  </div>
                                                @enderror

                                                <div class="form-group">
                                                  <select class=" form-control @error('month_print') is-invalid @enderror" name="month_print">
                                                        <option value="">-- Pilih Bulan--</option>
                                                        @for($i = 1; $i <= 12; $i++)
                                                          @if($i == 1)
                                                            <option value="{{ $i }}">Januari</option>
                                                          @elseif($i == 2)
                                                            <option value="{{ $i }}">Februari</option>
                                                          @elseif($i == 3)
                                                            <option value="{{ $i }}">Maret</option>
                                                          @elseif($i == 4)
                                                            <option value="{{ $i }}">April</option>
                                                          @elseif($i == 5)
                                                            <option value="{{ $i }}">Mei</option>
                                                          @elseif($i == 6)
                                                            <option value="{{ $i }}">Juni</option>
                                                          @elseif($i == 7)
                                                            <option value="{{ $i }}">Juli</option>
                                                          @elseif($i == 8)
                                                            <option value="{{ $i }}">Agustus</option>
                                                          @elseif($i == 9)
                                                            <option value="{{ $i }}">September</option>
                                                          @elseif($i == 10)
                                                            <option value="{{ $i }}">Oktober</option>
                                                          @elseif($i == 11)
                                                            <option value="{{ $i }}">November</option>
                                                          @else
                                                            <option value="{{ $i }}">Desember</option>
                                                          @endif
                                                        @endfor
                                                      </select>
                                                </div>

                                                @error('month_print')
                                                  <div class="alert alert-danger" role="alert">
                                                      {{ $message }}
                                                  </div>
                                                @enderror

                                                <div class="form-group">
                                                  <select class="form-control @error('year_print') is-invalid @enderror" name="year_print">
                                                    <option value="">-- Pilih Tahun--</option>
                                                    @for($i = 2020; $i <= 2045; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                  </select>
                                                </div>

                                                @error('year_print')
                                                  <div class="alert alert-danger" role="alert">
                                                      {{ $message }}
                                                  </div>
                                                @enderror

                                              <div>
                                                @php
                                                $count = $transactions->count();
                                                @endphp
                                                @if($count == 0)
                                                  <button id="payment-button" type="submit" class="btn btn-info btn-block" disabled>
                                                    <span id="payment-button-amount"><i class="fa fa-print"></i></span>
                                                  </button>
                                                @else
                                                <button id="payment-button" type="submit" class="btn btn-info btn-block">
                                                    <span id="payment-button-amount"><i class="fa fa-print"></i></span>
                                                  </button>
                                                @endif
                                              </div>
                                          </form>
                                        </div>

                                        <div class="tab-pane fade" id="custom-nav-contact" role="tabpanel" aria-labelledby="custom-nav-contact-tab">
                                            <table id="main-data-table" class="table table-striped">
                                                <thead>
                                                  <tr>
                                                    <th>#</th>
                                                    <th>Kode</th>
                                                    <th>Nama Nasabah</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  @php
                                                  $i = 1;
                                                  @endphp
                                                  @foreach($transaction_ontrashed as $trash)
                                                  <tr>
                                                    <td>{{ $i++}}.</td>
                                                    <td>{{ ucfirst($trash->code )}}</td>
                                                    <td>{{ ucfirst($trash->customer->name )}}</td>
                                                    <td><span class="badge badge-warning">Dihapus</span></td>
                                                    <td>
                                                      <form method="POST" action="{{route('transaction.restore', $trash->id)}}">
                                                        @csrf
                                                        <input type="text" name="id" value="{{ $trash->id }}" hidden="true">
                                                        <button class="btn btn-secondary btn-sm" type="submit"><i class="fa fa-reply"></i></button>
                                                        <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#forceDelete{{$trash->id}}"><i class="fa fa-trash"></i></a>
                                                      </form>
                                                    </td>
                                                  </tr>
                                                  @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>


                        </div>
                    </div><!-- .animated -->
                </div><!-- .content -->
            </div>
        </div>
        <!-- MODAL -->
        @foreach($transactions as $val)
        <div class="modal fade" id="deleteModal{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <form method="POST" action="{{ route('transaction.destroy', $val->id)}}">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="mediumModalLabel">Hapus {{$val->code}} ?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Hapus data transaksi {{ $val->code }}
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                  </form>
                </div>
            </div>
        </div>
        @endforeach
        @foreach($transaction_ontrashed as $trash)
        <div class="modal fade" id="forceDelete{{$trash->id}}" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form method="POST" action="{{route('transaction.force', $trash->id)}}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $trash->id}}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mediumModalLabel">Hapus permanen {{$trash->code}} ?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Hapus permanen data transaksi {{ $trash->code }}
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger" >Hapus</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
        <!-- END MODAL -->
    </div>
</main>

@endsection

@section('js')
 <script>
    $(document).ready(function() {
        var table = $('#example').DataTable( {
            lengthChange: false,
            buttons: [ 'copy', 'pdf', 'print', 'colvis' ]
        } );
     
        table.buttons().container()
            .appendTo( '#example_wrapper .col-md-6:eq(0)' );
    } );
 </script>
@endsection