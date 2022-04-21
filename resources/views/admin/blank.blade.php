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
        <li class="breadcrumb-item active">Administrator</li>
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
                            <strong class="card-title">Basic Table</strong>
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
                                            <td>
                                                <select name="addmore[0][trashtype_id]" id="addmore[0][trashtype_id]" class="form-control" required="required">
                                                    <option value="">-- PILIH --</option>
                                                    @foreach ($trashtypes as $value)
                                                    <option value="{{ $value->id}}"> {{ $value->name }}</option>   
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="addmore[0][trashprice_id]" id="trashprice_id" class="form-control" required="required">
                                                    <option>-- PILIH --</option>
                                                </select>
                                            </td>
                                            <td >
                                                <select name="addmore[0][trashprice]" id="trashprice" class="form-control" required="required">
                                                    <option value="">-- PILIH --</option>
                                                </select>
                                            </td>
                                            <td style="width: 150px;">
                                                <div class="input-group">
                                                    <input class="form-control" type="number" id="weight" name="addmore[0][weight]" min="0" max="50" step="0.1" placeholder="0.1" required="required">
                                                    <div class="input-group-addon">kg</div>
                                                </div>
                                            </td>
                                            <td style="width: 150px;">
                                                <div class="input-group">
                                                    <div class="input-group-addon">Rp.</div>
                                                    <input class="form-control" type="number" id="sub_total" name="addmore[0][sub_total]" min="0" step="0.1" placeholder="0.1" readonly="readonly">
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
                        jQuery.each(data, function(key,value){
                           $('select[name="addmore[0][trashprice_id]"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                     }
                  });
               }
               else
               {
                $('select[name="addmore[0][trashprice_id]"]').empty();
                $('select[name="addmore[0][trashprice]"]').empty();
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
                        jQuery('select[name="addmore[0][trashprice]"]').empty();
                        jQuery.each(data, function(key,value){
                           $('select[name="addmore[0][trashprice]"]').append('<option value="'+ value +'">Rp. '+ value +'</option>');
                        });
                     }
                  });
               }
               else
               {
                $('select[name="addmore[0][trashprice]"]').empty();
               }
            });

            $("#weight, #trashprice").on('change', function() {
              var trashprice  = $("#trashprice").val();
              var weight = $("#weight").val();

              var sub_total = parseFloat(trashprice) * parseFloat(weight);
              $("#sub_total").val(sub_total);
            });
        });
    </script>

    <script type="text/javascript">
        var i = 0;

        $("#add").click(function(){
            ++i;
            $("#dynamicTable").append('<tr><td><select name="addmore['+i+'][trashtype_id]" id="addmore['+i+'][trashtype_id]" class="form-control"><option value="">-- PILIH --</option>@foreach ($trashtypes as $value)<option value="{{ $value->id}}"> {{ $value->name }}</option>@endforeach</select></td><td><select name="addmore['+i+'][trashprice_id]" id="addmore['+i+'][trashprice_id]" class="form-control"><option>-- PILIH --</option></select></td><td><select name="addmore['+i+'][trashprice]" id="addmore['+i+'][trashprice]" class="form-control"><option value="">-- PILIH --</option></select></td><td><div class="input-group"><input class="form-control" type="number" id="addmore['+i+'][weight]" name="addmore['+i+'][weight]" min="0" max="50" step="0.1" placeholder="0.1"><div class="input-group-addon">kg</div></div></td><td><div class="input-group"><input class="form-control" type="number" id="sub_total2" name="addmore['+i+'][sub_total]" min="0" max="50" step="0.1" placeholder="0.1" readonly="readonly"><div class="input-group-addon">kg</div></div></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');

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
                        jQuery.each(data, function(key,value){
                           $('select[name="addmore['+i+'][trashprice_id]"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                     }
                  });
               }
               else
               {
                $('select[name="addmore['+i+'][trashprice_id]"]').empty();
                $('select[name="addmore['+i+'][trashprice]"]').empty();
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
                        jQuery('select[name="addmore['+i+'][trashprice]"]').empty();
                        jQuery.each(data, function(key,value){
                           $('select[name="addmore['+i+'][trashprice]"]').append('<option value="'+ value +'">Rp. '+ value +'</option>');
                        });
                     }
                  });
               }
               else
               {
                $('select[name="addmore['+i+'][trashprice]"]').empty();
               }
            });

            $('select[name="addmore['+i+'][trashprice]"], select[name="addmore['+i+'][weight]"]').on('change', function() {
              
              var trashprice  = $('select[name="addmore['+i+'][trashprice]"]').val();
              var weight = $('select[name="addmore['+i+'][weight]"]').val();

              var sub_total = parseFloat(trashprice) * parseFloat(weight);
              $('#sub_total2').val(trashprice);
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
@endsection