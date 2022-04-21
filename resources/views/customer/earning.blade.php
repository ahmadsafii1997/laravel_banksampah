<!-- FUNGSI EXTENDS DIGUNAKAN UNTUK ME-LOAD MASTER LAYOUTS YANG ADA, KARENA INI ADALAH HALAMAN HOME MAKA KITA ME-LOAD LAYOUTS ADMIN.BLADE.PHP -->
<!-- KETIKA MELOAD FILE BLADE, MAKA EKSTENSI .BLADE.PHP TIDAK PERLU DITULISKAN -->
@extends('admin.layouts.customer_layout')

<!-- TAG YANG DIAPIT OLEH SECTION('TITLE') AKAN ME-REPLACE @YIELD('TITLE') PADA MASTER LAYOUTS -->
@section('title')
    <title>Saldo | Nasabah</title>
@endsection

<!-- TAG YANG DIAPIT OLEH SECTION('CONTENT') AKAN ME-REPLACE @YIELD('CONTENT') PADA MASTER LAYOUTS -->
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Saldo</li>
    </ol>
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
                                                    <th>Tanggal</th>
                                                    <th>Jumlah</th>
                                                    <th>Status</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                    $i = 1;
                                                    @endphp
                                                    @foreach($withdraws as $withdraw)
                                                    <tr>
                                                        <td>{{$i++}}.</td>
                                                        <td>Penarikan | {{$withdraw->created_at->translatedFormat('d F Y')}}</td>
                                                        <td>Rp.{{ number_format($withdraw->amount)}}</td>
                                                        @if($withdraw->status == 0)
                                                        <td><span class="badge badge-secondary">Menunggu</span></td>
                                                        @else
                                                        <td><span class="badge badge-success">Disetujui</span></td>
                                                        @endif

                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <thead>
                                                  <tr>
                                                    <th colspan="2">Sisa Saldo</th>
                                                    <th colspan="1">Rp.{{number_format($earnings->earning)}}</th>
                                                    <th>
                                                        @if($earnings->earning == 0)
                                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#showModal{{$earnings->id}}" disabled><img class="user-avatar" src="{{ asset('admin/images/withdraw.png')}}" style="max-width: 30px;" alt="User Avatar"></button> 
                                                        @else
                                                          <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#showModal{{$earnings->id}}"><img class="user-avatar" src="{{ asset('admin/images/withdraw.png')}}" style="max-width: 30px;" alt="User Avatar"> Tarik Dana</button>
                                                        @endif
                                                    </th>
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