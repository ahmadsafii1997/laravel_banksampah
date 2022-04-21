<!-- FUNGSI EXTENDS DIGUNAKAN UNTUK ME-LOAD MASTER LAYOUTS YANG ADA, KARENA INI ADALAH HALAMAN HOME MAKA KITA ME-LOAD LAYOUTS ADMIN.BLADE.PHP -->
<!-- KETIKA MELOAD FILE BLADE, MAKA EKSTENSI .BLADE.PHP TIDAK PERLU DITULISKAN -->
@extends('admin.layouts.director_layout')

<!-- TAG YANG DIAPIT OLEH SECTION('TITLE') AKAN ME-REPLACE @YIELD('TITLE') PADA MASTER LAYOUTS -->
@section('title')
    <title>Dashboard</title>

    <style type="text/css">
        #loader {
            position: absolute;
            right: 18px;
            top: 30px;
            width: 20px;
        }
    </style>
@endsection

<!-- TAG YANG DIAPIT OLEH SECTION('CONTENT') AKAN ME-REPLACE @YIELD('CONTENT') PADA MASTER LAYOUTS -->
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Beranda</li>
        <li class="breadcrumb-item">Transaksi</li>
        <li class="breadcrumb-item active">Detail Transaksi</li>
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
                        <div class="card-header">
                          <strong class="card-title">Detail Transaksi</strong>
                          <div class="float-right">
                            <strong class="card-title">
                                <nav>
                                    <div class="nav nav-pills" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="main-nav-tab" data-toggle="tab" href="#main-nav" role="tab" aria-controls="main-nav" aria-selected="true"><i class="fa fa-table"></i></a>
                                    </div>
                                </nav>
                                <!--
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                  Launch demo modal
                                </button>
                            -->
                            </strong>
                        </div>
                      </div>
                        <div class="card-body">
                            <div class="custom-tab">                                
                                <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="main-nav" role="tabpanel" aria-labelledby="main-nav-tab">
                                      <div class="row form-group">
                                          <div class="col col-md-3"><label class=" form-control-label">Kode Transaksi</label></div>
                                          <div class="col-12 col-md-9">
                                            <select name="customer_id" class="form-control" readonly>
                                                @foreach($transaction as $trans)
                                                <option value="" >{{ $trans->code }}</option>
                                                @endforeach

                                            </select>
                                          </div>
                                      </div>

                                      <div class="row form-group">
                                          <div class="col col-md-3"><label class=" form-control-label">Nama Nasabah</label></div>
                                          <div class="col-12 col-md-9">
                                              <select name="customer_id" class="form-control" readonly>
                                                  @foreach($transaction as $trans)
                                                  <option value="" > {{ ucfirst($trans->customer->name)}} </option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div>
                                      <br>

                                      <table class="table table-striped">
                                        <thead>
                                          <tr>
                                            <th>#</th>
                                            <th>Sampah</th>
                                            <th>Jenis Sampah</th>
                                            <th>Volume</th>
                                            <th>Harga</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          @php
                                          $i = 1;
                                          @endphp
                                          @foreach($detail_transactions as $trans)
                                          <tr>
                                            <td>{{ $i++}}.</td>
                                            <td>{{$trans->trashprice->name}}</td>
                                            <td>{{$trans->trashtype->name}}</td>
                                            <td>{{$trans->qty}} kg</td>
                                            <td>Rp.{{number_format($trans->subtotal)}}</td>
                                          </tr>
                                          @endforeach
                                        </tbody>
                                        <thead>
                                          <tr>
                                            <th colspan="4">Total</th>
                                            <th colspan="2">Rp.{{number_format($total)}}</th>
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
        @foreach($detail_transactions as $val)
        <div class="modal fade" id="updateModal{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteModal{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <form method="POST" action="{{ route('detailtransaction.destroy', $val->id)}}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="transaction_id" value="{{$val->transaction->id}}">
                    @foreach($transaction as $trans)
                    <input type="hidden" name="customer_id" value="{{$trans->customer->id}}">
                    @endforeach
                    <div class="modal-header">
                        <h5 class="modal-title" id="mediumModalLabel">Hapus {{$val->transaction->code}} ?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Hapus data transaksi {{ $val->transaction->code }}
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
        @foreach($detail_ontrashed as $trash)
        <div class="modal fade" id="forceDelete{{$trash->id}}" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form method="POST" action="{{route('detailtransaction.force', $trash->id)}}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $trash->id}}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mediumModalLabel">Hapus permanen {{$trash->trashprice->name}} ?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Hapus permanen data detail transaksi 
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
      window.setTimeout(function() {
        $("#alerts").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove(); 
        });
      }, 5000);
    </script>

    <script type="text/javascript">
        jQuery(document).ready(function ()
        {
            jQuery('select[name="addmore[0][trashtype_id]"]').on('change',function(){
               var trashtypeID = jQuery(this).val();
               if(trashtypeID)
               {
                  jQuery.ajax({
                     url : 'dropdown/getprices/' +trashtypeID,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        console.log(data);
                        jQuery('select[name="addmore[0][trashprice_id]"]').empty();
                        $('select[name="addmore[0][trashprice_id]"]').append('<option value="">-- PILIH --</option>');
                        jQuery.each(data, function(key,value){
                           $('select[name="addmore[0][trashprice_id]"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                     }
                  });
               }
               else
               {
                $('select[name="addmore[0][trashprice_id]"]').empty();
                $('select[name="addmore[0][price]"]').empty();
               }
            });

            jQuery('select[name="addmore[0][trashprice_id]"]').on('change',function(){
               var trashpriceID = jQuery(this).val();
               if(trashpriceID)
               {
                  jQuery.ajax({
                     url : 'dropdown/prices/' +trashpriceID,
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
        });
    </script>
@endsection