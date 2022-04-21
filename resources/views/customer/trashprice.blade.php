<!-- FUNGSI EXTENDS DIGUNAKAN UNTUK ME-LOAD MASTER LAYOUTS YANG ADA, KARENA INI ADALAH HALAMAN HOME MAKA KITA ME-LOAD LAYOUTS ADMIN.BLADE.PHP -->
<!-- KETIKA MELOAD FILE BLADE, MAKA EKSTENSI .BLADE.PHP TIDAK PERLU DITULISKAN -->
@extends('admin.layouts.customer_layout')

<!-- TAG YANG DIAPIT OLEH SECTION('TITLE') AKAN ME-REPLACE @YIELD('TITLE') PADA MASTER LAYOUTS -->
@section('title')
    <title>Data Harga Sampah | Nasabah</title>
@endsection

<!-- TAG YANG DIAPIT OLEH SECTION('CONTENT') AKAN ME-REPLACE @YIELD('CONTENT') PADA MASTER LAYOUTS -->
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Data Master Sampah</li>
        <li class="breadcrumb-item active">Daftar Harga</li>
    </ol>

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
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="float-left">
                                    <strong class="card-title" v-if="headerText">Data Harga Sampah</strong>
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
                                                    <th>Nama Sampah</th>
                                                    <th>Kategori Sampah</th>
                                                    <th>Harga</th>
                                                    <th>Status</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                    $i = 1;
                                                    @endphp
                                                  @foreach($trashprice as $val)
                                                      <tr>
                                                        <td>{{$i++}}.</td>
                                                        <td>{{ ucfirst($val->name) }}</td>
                                                        <td>{{ ucfirst($val->trashtype->name) }}</td>
                                                        <td>Rp.{{ $val->price }}/{{ $val->unit }}</td>
                                                        @if($val->status == 1)
                                                        <td><span class="badge badge-primary">Aktif</span></td>
                                                        @else
                                                        <td><span class="badge badge-secondary">Tidak Aktif</span></td>
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
@endsection