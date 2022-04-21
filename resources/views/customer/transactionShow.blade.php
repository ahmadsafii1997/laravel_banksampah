<!-- FUNGSI EXTENDS DIGUNAKAN UNTUK ME-LOAD MASTER LAYOUTS YANG ADA, KARENA INI ADALAH HALAMAN HOME MAKA KITA ME-LOAD LAYOUTS ADMIN.BLADE.PHP -->
<!-- KETIKA MELOAD FILE BLADE, MAKA EKSTENSI .BLADE.PHP TIDAK PERLU DITULISKAN -->
@extends('admin.layouts.customer_layout')

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
                        </div>
                        <div class="card-body">
                            <div class="custom-tab">                                
                                <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="main-nav" role="tabpanel" aria-labelledby="main-nav-tab">
                                      <div class="row form-group">
                                          <div class="col col-md-3"><label class=" form-control-label">Kode Transaksi</label></div>
                                          <div class="col-12 col-md-9">
                                            <select name="customer_id" class="form-control" readonly>
                                                @foreach($detailtransactions as $detail)
                                                <option value="" >{{ $detail->transaction->code }}</option>
                                                @endforeach

                                            </select>
                                          </div>
                                      </div>
                                      <br>

                                      <table class="table table-striped ">
                                        <thead>
                                          <tr>
                                            <th>#</th>
                                            <th>Sampah</th>
                                            <th>Jenis Sampah</th>
                                            <th>Volume</th>
                                            <th>Harga</th>
                                        </thead>
                                        <tbody>
                                          @php($i = 1)
                                          @foreach($detailtransactions as $trans)
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
                                        <tbody>
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