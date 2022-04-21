<!-- FUNGSI EXTENDS DIGUNAKAN UNTUK ME-LOAD MASTER LAYOUTS YANG ADA, KARENA INI ADALAH HALAMAN HOME MAKA KITA ME-LOAD LAYOUTS ADMIN.BLADE.PHP -->
<!-- KETIKA MELOAD FILE BLADE, MAKA EKSTENSI .BLADE.PHP TIDAK PERLU DITULISKAN -->
@extends('admin.layouts.director_layout')

<!-- TAG YANG DIAPIT OLEH SECTION('TITLE') AKAN ME-REPLACE @YIELD('TITLE') PADA MASTER LAYOUTS -->
@section('title')
    <title>Data Transaksi | Direktur</title>
@endsection

<!-- TAG YANG DIAPIT OLEH SECTION('CONTENT') AKAN ME-REPLACE @YIELD('CONTENT') PADA MASTER LAYOUTS -->
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Data Transaksi</li>
    </ol>
    <div class="container-fluid">
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
                    <div class="content mt-3">
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
                                                        <table id="example" class="table table-striped">
                                                            <thead>
                                                              <tr>
                                                                <th>#</th>
                                                                <th>Kode</th>
                                                                <th>Nama Nasabah</th>
                                                                <th>Admin</th>
                                                                <th>Biaya Admin</th>
                                                                <th>Total</th>
                                                              </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                $i = 1;
                                                                @endphp
                                                              @foreach($transactions as $val)
                                                                  <tr>
                                                                    <td>{{$i++}}.</td>
                                                                    <td><a href="{{ route('director.transaction.show', $val->id)}}"><span class="badge badge-primary">{{ ucfirst($val->code )}}</span></a></td>
                                                                    <td>{{ ucfirst($val->customer->name) }}</td>
                                                                    <td>{{ ucfirst($val->admin->name) }}</td>
                                                                    <td>Rp.{{ number_format($val->admin_fee) }}</td>
                                                                    <td>Rp.{{ number_format($val->subtotal) }}</td>
                                                                  </tr>
                                                                @endforeach
                                                                <thead>
                                                              <tr>
                                                                <th colspan="4">Total</th>
                                                                <th colspan="1">Rp.{{ number_format($transactions->sum('admin_fee'))}}</th>
                                                                <th colspan="1">Rp.{{ number_format($transactions->sum('subtotal'))}}</th>
                                                              </tr>
                                                            </thead>
                                                            </tbody>
                                                            
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

@section('js')
    <script src="{{ asset('admin/assets/js/lib/data-table/datatables.min.js')}}"></script>
    <script src="{{ asset('admin/assets/js/lib/data-table/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{ asset('admin/assets/js/lib/data-table/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('admin/assets/js/lib/data-table/buttons.bootstrap.min.js')}}"></script>
    <script src="{{ asset('admin/assets/js/lib/data-table/jszip.min.js')}}"></script>
    <script src="{{ asset('admin/assets/js/lib/data-table/pdfmake.min.js')}}"></script>
    <script src="{{ asset('admin/assets/js/lib/data-table/vfs_fonts.js')}}"></script>
    <script src="{{ asset('admin/assets/js/lib/data-table/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('admin/assets/js/lib/data-table/buttons.print.min.js')}}"></script>
    <script src="{{ asset('admin/assets/js/lib/data-table/buttons.colVis.min.js')}}"></script>
    <script src="{{ asset('admin/assets/js/lib/data-table/datatables-init.js')}}"></script>

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