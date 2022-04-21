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
        <li class="breadcrumb-item">Data Pengguna</li>
        <li class="breadcrumb-item">Nasabah</li>
        <li class="breadcrumb-item active">
            @foreach($customer as $val)
                {{ ucfirst($val->name)}}
            @endforeach
        </li>
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
                    <div class="card">
                        <aside class="profile-nav alt">
                            @foreach($customer as $val)
                            <section class="card">
                                <div class="card-header user-header alt bg-dark">
                                    <div class="media">
                                        <a href="#">
                                            <img class="align-self-center rounded-circle mr-3" style="width:85px; height:85px;" alt="" src="{{ asset('admin/images/admin.jpg')}}">
                                        </a>
                                        <div class="media-body">
                                            <div class="col-lg-6">
                                                <div class="float-left">
                                                    <br />
                                                    <h2 class="text-white display-6">{{ ucfirst($val->name)}}</h2>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 text-right text-light">
                                                <footer class="blockquote-footer">Total Saldo</footer>
                                                <span class="badge badge-secondary">
                                                    <h2>
                                                        @if($val->earning == null)
                                                            Rp.{{ 0 }}
                                                        @else
                                                            Rp.{{ number_format($val->earning) }}
                                                        @endif
                                                    </h2>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <h6><i class="fa fa-user"></i> Nomor Induk Kependudukan<span class="badge badge-secondary pull-right">{{$val->nik}}</span></h6>
                                    </li>
                                    <li class="list-group-item">
                                        <h6><i class="fa fa-map-marker"></i> Alamat<span class="pull-right">{{($val->address)}}</span></h6>
                                    </li>

                                    @if($val->phone != null)
                                    <li class="list-group-item">
                                        <h6><i class="fa fa-phone"></i> Nomor Telepon<span class="badge badge-secondary pull-right">{{$val->phone}}</span></h6>
                                    </li>
                                    @else
                                    <li class="list-group-item">
                                        <h6><i class="fa fa-phone"></i> Nomor Telepon<span class="badge badge-secondary pull-right">Tidak Ada Nomor Telepon</span></h6>
                                    </li>
                                    @endif
                                </ul>

                            </section>
                            @endforeach
                        </aside>
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
@endsection