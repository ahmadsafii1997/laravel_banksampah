<!-- FUNGSI EXTENDS DIGUNAKAN UNTUK ME-LOAD MASTER LAYOUTS YANG ADA, KARENA INI ADALAH HALAMAN HOME MAKA KITA ME-LOAD LAYOUTS ADMIN.BLADE.PHP -->
<!-- KETIKA MELOAD FILE BLADE, MAKA EKSTENSI .BLADE.PHP TIDAK PERLU DITULISKAN -->
@extends('admin.layouts.layout')

<!-- TAG YANG DIAPIT OLEH SECTION('TITLE') AKAN ME-REPLACE @YIELD('TITLE') PADA MASTER LAYOUTS -->
@section('title')
    <title>Admin | Saldo</title>
@endsection

<!-- TAG YANG DIAPIT OLEH SECTION('CONTENT') AKAN ME-REPLACE @YIELD('CONTENT') PADA MASTER LAYOUTS -->
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Transaksi</li>
        <li class="breadcrumb-item active">Saldo</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
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

                

                <div class="content mt-3">
                    <div class="animated fadeIn">
                        <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                      <div class="float-left">
                                          <strong class="card-title" v-if="headerText">Data Penarikan Saldo</strong>
                                      </div>
                                      <div class="float-right">
                                            <strong class="card-title">
                                                <nav>
                                                    <div class="nav nav-pills" id="nav-tab" role="tablist">
                                                        <a class="nav-item nav-link active" id="main-nav-tab" data-toggle="tab" href="#main-nav" role="tab" aria-controls="main-nav" aria-selected="true"><i class="fa fa-table"></i></a>
                                                        <a class="nav-item nav-link" id="custom-nav-out-tab" data-toggle="tab" href="#custom-nav-out" role="tab" aria-controls="custom-nav-out" aria-selected="false"><i class="fa fa-money"></i></a>
                                                        <!--
                                                        <a class="nav-item nav-link" id="custom-nav-print-tab" data-toggle="tab" href="#custom-nav-print" role="tab" aria-controls="custom-nav-print" aria-selected="false"><i class="fa fa-print"></i></a>
                                                    -->
                                                    </div>
                                                </nav>
                                            </strong>
                                        </div>
                                  </div>
                                <div class="card-body">
                                  <div class="custom-tab">                                
                                    <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="main-nav" role="tabpanel" aria-labelledby="main-nav-tab">
                                            <table id="main-data-table-export" class="table table-striped">
                                                <thead>
                                                    <th>#</th>
                                                    <th>Nama Nasabah</th>
                                                    <th>Jumlah</th>
                                                    <th>Biaya Admin</th>
                                                    <th>Aksi</th>
                                                </thead>
                                                <tbody>
                                                  @php
                                                  $i = 1;
                                                  @endphp
                                                  @foreach($customers as $val)
                                                  <tr>
                                                    <td data-tableexport-cellformat="">{{$i++}}.</td>
                                                    <td>{{ ucfirst($val->name )}}</td>
                                                    <td>Rp. {{ number_format($val->earning) }}</td>
                                                    @php
                                                    $admin_fee = 0.1*($val->earning);
                                                    @endphp
                                                    <td>Rp. {{ number_format($admin_fee) }}</td>
                                                    <td>
                                                    @if($val->earning == 0)
                                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#showModal{{$val->id}}" disabled><img class="user-avatar" src="{{ asset('admin/images/withdraw.png')}}" style="max-width: 15px;" alt="User Avatar"></button>
                                                    @else
                                                      <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#showModal{{$val->id}}"><img class="user-avatar" src="{{ asset('admin/images/withdraw.png')}}" style="max-width: 15px;" alt="User Avatar"></button>
                                                    @endif
                                                    </td>
                                                  </tr>
                                                  @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="tab-pane fade" id="custom-nav-out" role="tabpanel" aria-labelledby="custom-nav-out-tab">
                                            <table id="bootstrap-data-table-export" class="table table-striped dt-responsive nowrap" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nama Nasabah</th>
                                                        <th>Jumlah</th>
                                                        <th>Status</th>
                                                        <th>Tanggal</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                    $i = 1;
                                                      @endphp
                                                      @foreach($withdraws as $val)
                                                      <tr>
                                                        <td>{{ $i++ }}.</td>
                                                        <td>{{ ucfirst($val->customer->name )}}</td>
                                                        <td>Rp. {{ number_format($val->amount) }}</td>
                                                        @if($val->status == 0)
                                                        <td><span class="badge badge-secondary">Menunggu</span></td>
                                                        @else
                                                        <td><span class="badge badge-success">Disetujui</span></td>
                                                        @endif
                                                        <td>{{ $val->created_at->translatedFormat('d F Y')}}</td>
                                                        @if($val->status == 0)
                                                        <td><button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#updateModal{{$val->id}}"><i class="fa fa-pencil"></i></button></td>
                                                        @else
                                                        <td><button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#updateModal{{$val->id}}" disabled><i class="fa fa-pencil"></i></button></td>
                                                        @endif
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
        @foreach($customers as $val)
        <div class="modal fade" id="showModal{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <form method="POST" action="{{route('earning.withdraw', $val->id)}}">
                    @csrf
                    @method('POST')
                    <div class="modal-header">
                        <h5 class="modal-title" id="mediumModalLabel">Tarik dana?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="customer_id" value="{{$val->id}}">
                        <div class="row form-group">
                            <div class="col col-md-6">
                              <div class="input-group">
                                <input type="text" id="input3-group1" name="customer_nik" value="{{$val->nik}}" class="form-control" readonly>
                              </div>
                            </div>
                            <div class="col col-md-6">
                              <div class="input-group">
                                <input type="text" id="input3-group1" name="customer_name" value="{{ ucfirst($val->name)}}" class="form-control" readonly>
                              </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-12">
                              <div class="input-group">
                                <div class="input-group-addon">Rp.</div>
                                <input type="text" id="input3-group1" name="earning" value="{{$val->earning}}" class="form-control" readonly>
                              </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cc-payment" class="control-label mb-1">Jumlah yang ingin ditarik</label>
                            <input id="cc-pament" name="amount" type="number" min="0" max="{{$val->earning}}" class="form-control @error('amount') is-invalid @enderror" value="{{old('amount')}}" aria-required="true" aria-invalid="false" required>
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
        @endforeach
        @foreach($withdraws as $val)

        <div class="modal fade" id="updateModal{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form action="{{route('withdraw.update', $val->id)}}" method="post" novalidate="novalidate">
                      @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="mediumModalLabel">Perbarui Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                          <input type="hidden" name="id" value="{{ $val->id }}">
                         
                              <div class="form-group">
                                <label for="status" class="control-label mb-1">Status</label>
                                  <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                    @if($val->status == 0)
                                        <option value="1">Disetujui</option>
                                        <option value="0" selected>Menunggu</option>
                                    @else
                                        <option value="1" selected>Disetujui</option>
                                        <option value="0">Menunggu</option>
                                    @endif
                                </select>
                            </div>
                            @error('status')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                          
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</main>

@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
          $('#main-data-table-export').DataTable();
          $('#bootstrap-data-table-export').DataTable();
        } );

    </script>

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

    <script>
        jQuery('select[name="customer_id"]').on('change',function(){
               var customerID = jQuery(this).val();
               if(customerID)
               {
                  jQuery.ajax({
                     url : 'getStates/' +customerID,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        console.log(data);
                        jQuery('select[name="addmore[0][price]"]').empty();
                        jQuery.each(data, function(key,value){
                           $('select[name="addmore[0][price]"]').append('<option value="'+ value +'">Rp. '+ value +'</option>');
                        });
                     }
                  });
               }
               else
               {
                $('select[name="addmore[0][price]"]').empty();
               }
            });
    </script>

    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable( {
                lengthChange: false,
                //buttons: [ 'copy', 'excel', 'csv', 'pdf', 'print', 'colvis' ]
                buttons: [  'copy', 'pdf', 'print', 'colvis']
            } );
            table.buttons().container()
                .appendTo( '#example_wrapper .col-md-6:eq(0)' );
        } );
     </script>
@endsection