<!-- FUNGSI EXTENDS DIGUNAKAN UNTUK ME-LOAD MASTER LAYOUTS YANG ADA, KARENA INI ADALAH HALAMAN HOME MAKA KITA ME-LOAD LAYOUTS ADMIN.BLADE.PHP -->
<!-- KETIKA MELOAD FILE BLADE, MAKA EKSTENSI .BLADE.PHP TIDAK PERLU DITULISKAN -->
@extends('admin.layouts.layout')

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
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Users</li>
        <li class="breadcrumb-item active">Transactions</li>
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
                            <strong class="card-title">Transaksi id = {{$s}}</strong>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('dropdown.post')}}">
                                @csrf
                            <table class="table" id="dynamicTable">
                                <thead>
                                    <tr>
                                        <th scope="col">Kategori Sampah</th>
                                        <th scope="col">Nama Sampah</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Berat</th>
                                        <th scope="col">Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                            <input type="hidden" name="addmore[0][transaction_id]" id="addmore[0][transaction_id]" value="1">
                                        <td>
                                            <select name="addmore[0][trashtype_id]" id="addmore[0][trashtype_id]" class="form-control" required="required">
                                                <option value="">-- PILIH --</option>
                                                @foreach ($trashtypes as $value)
                                                <option value="{{ $value->id}}"> {{ $value->name }}</option>   
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="addmore[0][trashprice_id]" id="addmore[0][trashprice_id]" class="form-control" required="required">
                                                <option>-- PILIH --</option>
                                            </select>
                                        </td>
                                        <td >
                                            <select name="addmore[0][price]" id="addmore[0][price]" class="form-control" required="required">
                                                <option value="">-- PILIH --</option>
                                            </select>
                                        </td>
                                        <td style="width: 150px;">
                                            <div class="input-group">
                                                <input class="form-control" type="number" id="addmore[0][qty]" name="addmore[0][qty]" min="0" max="50" step="0.1" placeholder="0.1" required>
                                                <div class="input-group-addon">kg</div>
                                            </div>
                                        </td>
                                        <td style="width: 20px;">
                                            <button type="button" name="add" id="add" class="btn btn-success">Add More</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-success">Save</button>
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

    <script type="text/javascript">
        var i = 0;

        $("#add").click(function(){
            ++i;
            $("#dynamicTable").append('<tr><input type="hidden" name="addmore['+i+'][transaction_id]" id="addmore['+i+'][transaction_id]" value="1"><td><select name="addmore['+i+'][trashtype_id]" id="addmore['+i+'][trashtype_id]" class="form-control"><option value="">-- PILIH --</option>@foreach ($trashtypes as $value)<option value="{{ $value->id}}"> {{ $value->name }}</option>@endforeach</select></td><td><select name="addmore['+i+'][trashprice_id]" id="addmore['+i+'][trashprice_id]" class="form-control"><option>-- PILIH --</option></select></td><td><select name="addmore['+i+'][price]" id="addmore['+i+'][price]" class="form-control"><option value="">-- PILIH --</option></select></td><td><div class="input-group"><input class="form-control" type="number" id="addmore['+i+'][qty]" name="addmore['+i+'][qty]" min="0" max="50" step="0.1" placeholder="0.1" required><div class="input-group-addon">kg</div></div></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');

            jQuery('select[name="addmore['+i+'][trashtype_id]"]').on('change',function(){
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
                        jQuery('select[name="addmore['+i+'][trashprice_id]"]').empty();
                        $('select[name="addmore['+i+'][trashprice_id]"]').append('<option value="">-- PILIH --</option>');
                        jQuery.each(data, function(key,value){
                           $('select[name="addmore['+i+'][trashprice_id]"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                     }
                  });
               }
               else
               {
                $('select[name="addmore['+i+'][trashprice_id]"]').empty();
                $('select[name="addmore['+i+'][price]"]').empty();
               }
            });

            jQuery('select[name="addmore['+i+'][trashprice_id]"]').on('change',function(){
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
                        jQuery('select[name="addmore['+i+'][price]"]').empty();
                        jQuery.each(data, function(key,value){
                           $('select[name="addmore['+i+'][price]"]').append('<option value="'+ value +'">Rp. '+ value +'</option>');
                        });
                     }
                  });
               }
               else
               {
                $('select[name="addmore['+i+'][price]"]').empty();
               }
            });
        });

        $(document).on('click', '.remove-tr', function(){  
             $(this).parents('tr').remove();
        });  
    </script>

    <script>
      window.setTimeout(function() {
        $("#alerts").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove(); 
        });
      }, 5000);
    </script>

    <script type="text/javascript">
      

            $('.trashprice, .qty').on('change', function(){
                var trashprice = $(this).parent().find('.trashprice').val();
                var qty = $(this).parent().find('.qty').val();
                $(this).parent().find('.sub_total').val(trashprice * qty);
                var sum = 0;
                $(".sub_total").each(function(){
                    sum += +$(this).val();
                });
                $(#total).val(sum);
            });
    </script>
@endsection