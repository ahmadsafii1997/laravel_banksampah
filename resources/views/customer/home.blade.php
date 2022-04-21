<!-- FUNGSI EXTENDS DIGUNAKAN UNTUK ME-LOAD MASTER LAYOUTS YANG ADA, KARENA INI ADALAH HALAMAN HOME MAKA KITA ME-LOAD LAYOUTS ADMIN.BLADE.PHP -->
<!-- KETIKA MELOAD FILE BLADE, MAKA EKSTENSI .BLADE.PHP TIDAK PERLU DITULISKAN -->
@extends('admin.layouts.customer_layout')

<!-- TAG YANG DIAPIT OLEH SECTION('TITLE') AKAN ME-REPLACE @YIELD('TITLE') PADA MASTER LAYOUTS -->
@section('title')
    <title>Beranda | Nasabah</title>
@endsection

<!-- TAG YANG DIAPIT OLEH SECTION('CONTENT') AKAN ME-REPLACE @YIELD('CONTENT') PADA MASTER LAYOUTS -->
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Beranda</li>
    </ol>

    <div class="col-xl-6 col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="stat-widget-one">
                    <div class="stat-icon dib"><i class="fa fa-money text-success border-success"></i></div>
                    <div class="stat-content dib">
                        <div class="stat-text">Jumlah Saldo</div>
                        <div class="stat-digit">Rp. {{ number_format($earning)}}</div>
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
                    <div class="stat-icon dib"><i class="fa fa-exchange text-success border-success"></i></div>
                    <div class="stat-content dib">
                        <div class="stat-text">Jumlah Transaksi</div>
                        <div class="stat-digit">{{ ($detail->count())}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/.col-->

    <div class="col-xl-12 col-lg-12">
        <div class="card">
                @if($earnings->earning == 0)
                <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#showModal{{$earnings->id}}" disabled><i class="fa fa-money"></i></button> 
                @else
                  <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#showModal{{$earnings->id}}"><img class="user-avatar" src="{{ asset('admin/images/withdraw.png')}}" style="max-width: 30px;" alt="User Avatar"><br />Tarik Dana</button>
                @endif
        </div>
    </div>
    <!--/.col-->

    <div class="content mt-3">          
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="float-left">
                                    <strong class="card-title" v-if="headerText">Data Transaksi</strong>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="custom-tab">                                
                                    <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="main-nav" role="tabpanel" aria-labelledby="main-nav-tab">
                                            <table id="bootstrap-data-table" class="table table-striped">
                                                <thead>
                                                  <tr>
                                                    <th>#</th>
                                                    <th>Kode</th>
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
                                                    <td><a href="{{ route('customer.transactionShow', $value->id)}}"><span class="badge badge-primary">{{ ucfirst($value->code )}}</span></a></td>
                                                    <td>{{ $value->created_at->translatedFormat('d F Y')}}</td>
                                                    @php
                                                    {{$subtotal = $value->detailtransactions->sum('subtotal');}}
                                                    {{$admin_fee = $value->detailtransactions->sum('admin_fee');}}
                                                    @endphp
                                                    <td>Rp. {{ number_format($subtotal) }}</td>
                                                  </tr>
                                                  @endforeach
                                                </tbody>
                                                <thead>
                                                    <tr>
                                                        <th colspan="3">Jumlah Saldo</th>
                                                        <th>Rp. {{ number_format($earning)}}</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- MODAL -->
                    <div class="modal fade" id="showModal{{$earnings->id}}" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                              <form method="POST" action="{{route('customer_earning.withdraw', $earnings->id)}}">
                                @csrf
                                @method('POST')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="mediumModalLabel">Tarik dana?</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="customer_id" value="{{$earnings->id}}">
                                    <div class="row form-group">
                                        <div class="col col-md-12">
                                          <div class="input-group">
                                            <div class="input-group-addon">Rp.</div>
                                            <input type="text" id="input3-group1" name="earning" value="{{$earnings->earning}}" class="form-control" readonly>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Jumlah yang ingin ditarik</label>
                                        <input id="cc-pament" name="amount" type="number" min="0" max="{{$earnings->earning}}" class="form-control @error('amount') is-invalid @enderror" value="{{old('amount')}}" aria-required="true" aria-invalid="false" required>
                                    </div>
                                    @error('amount')
                                      <div class="alert alert-danger" role="alert">
                                          {{ $message }}
                                      </div>
                                    @enderror
                                    <div class="row form-group">
                                        <div class="col col-md-12">
                                            <label for="cc-payment" class="control-label mb-1">Konfirmasi kata sandi</label>
                                          <div class="input-group">
                                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                            <a class="input-group-addon" onclick="myFunction()" data-toggle="tooltip" title="Lihat kata sandi"><i class="fa fa-eye"></i></a>
                                          </div>
                                        </div>
                                        @error('password')
                                          <div class="alert alert-danger" role="alert">
                                              {{ $message }}
                                          </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                  <button type="submit" class="btn btn-primary">Tarik</button>
                                </div>
                              </form>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js')

    <script>
      window.setTimeout(function() {
        $("#alerts").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove(); 
        });
      }, 5000);
    </script>

    <script type="text/javascript">
      function myFunction() {
        var x = document.getElementById("password");
        if (x.type === "password") {
          x.type = "text";
        } else {
          x.type = "password";
        }
      }
    </script>
@endsection