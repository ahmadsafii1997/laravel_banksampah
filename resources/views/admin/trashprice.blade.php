<!-- FUNGSI EXTENDS DIGUNAKAN UNTUK ME-LOAD MASTER LAYOUTS YANG ADA, KARENA INI ADALAH HALAMAN HOME MAKA KITA ME-LOAD LAYOUTS ADMIN.BLADE.PHP -->
<!-- KETIKA MELOAD FILE BLADE, MAKA EKSTENSI .BLADE.PHP TIDAK PERLU DITULISKAN -->
@extends('admin.layouts.layout')

<!-- TAG YANG DIAPIT OLEH SECTION('TITLE') AKAN ME-REPLACE @YIELD('TITLE') PADA MASTER LAYOUTS -->
@section('title')
    <title>Data Harga Sampah | Admin</title>
@endsection

<!-- TAG YANG DIAPIT OLEH SECTION('CONTENT') AKAN ME-REPLACE @YIELD('CONTENT') PADA MASTER LAYOUTS -->
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Data Master Sampah</li>
        <li class="breadcrumb-item active">Daftar Harga</li>
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
                                        <strong class="card-title" v-if="headerText">Data Harga Sampah</strong>
                                    </div>
                                    <div class="float-right">
                                        <strong class="card-title">
                                            <nav>
                                                <div class="nav nav-pills" id="nav-tab" role="tablist">
                                                    <a class="nav-item nav-link active" id="main-nav-tab" data-toggle="tab" href="#main-nav" role="tab" aria-controls="main-nav" aria-selected="true"><i class="fa fa-table"></i></a>
                                                    <a class="nav-item nav-link" id="custom-nav-profile-tab" data-toggle="tab" href="#custom-nav-profile" role="tab" aria-controls="custom-nav-profile" aria-selected="false"><i class="fa fa-plus"></i></a>
                                                    <a class="nav-item nav-link" id="custom-nav-contact-tab" data-toggle="tab" href="#custom-nav-contact" role="tab" aria-controls="custom-nav-contact" aria-selected="false"><i class="fa fa-trash"></i></a>
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
                                                <table id="example" class="table table-striped">
                                                    <thead>
                                                      <tr>
                                                        <th>#</th>
                                                        <th>Nama Sampah</th>
                                                        <th>Kategori Sampah</th>
                                                        <th>Harga</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
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
                                                            <td>
                                                                <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#updateModal{{$val->id}}"><i class="fa fa-pencil"></i></button>
                                                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{$val->id}}"><i class="fa fa-trash"></i></button>
                                                            </td>
                                                          </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="tab-pane fade" id="custom-nav-profile" role="tabpanel" aria-labelledby="custom-nav-profile-tab">
                                                <form action="{{route('trashprice.store')}}" method="post" novalidate="novalidate">
                                                    @csrf
                                                  <div class="form-group">
                                                      <label for="trashtype_id" class="control-label mb-1">Jenis Sampah</label>
                                                      <select name="trashtype_id" class="form-control @error('trashtype_id') is-invalid @enderror" required>
                                                        <option value="">-- PILIH SALAH SATU --</option>
                                                        @foreach($trashtype as $type)
                                                          <option value="{{ $type->id }}">{{ ucfirst($type->name) }}</option>
                                                        @endforeach
                                                      </select>
                                                  </div>
                                                  @error('trashtype_id')
                                                    <div class="alert alert-danger" role="alert">
                                                        {{ $message }}
                                                    </div>
                                                  @enderror
                                                  <div class="form-group">
                                                      <label for="name" class="control-label mb-1">Nama Sampah</label>
                                                      <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Kertas Karton" value="{{old('name')}}">
                                                  </div>
                                                  @error('name')
                                                    <div class="alert alert-danger" role="alert">
                                                        {{ $message }}
                                                    </div>
                                                  @enderror
                                                  <div class="form-group">
                                                      <label for="description" class="control-label mb-1">Keterangan</label>
                                                      <textarea name="description" id="description" rows="4" placeholder="Kaleng minuman, dll" class="form-control @error('description') is-invalid @enderror">{{ old('description')}}</textarea>
                                                  </div>
                                                  @error('description')
                                                    <div class="alert alert-danger" role="alert">
                                                        {{ $message }}
                                                    </div>
                                                  @enderror
                                                  <div class="row form-group">
                                                    <div class="col col-md-12">
                                                        <label for="price" class="control-label mb-1">Harga Sampah</label>
                                                      <div class="input-group">
                                                        <div class="input-group-addon">Rp.</div>
                                                        <input id="price" name="price" type="text" class="form-control @error('price') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="1500" value="{{old('price')}}">
                                                          <select name="unit" class="input-group-addon" required>
                                                            <option value="kg">/Kg</option>
                                                            <option value="pcs">/Pcs</option>
                                                          </select>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  @error('price')
                                                    <div class="alert alert-danger" role="alert">
                                                        {{ $message }}
                                                    </div>
                                                  @enderror
                                                  <div class="form-group">
                                                    @php
                                                        $id = Auth::user()->id;
                                                        $name = Auth::user()->name;
                                                    @endphp
                                                      <label for="admin_id" class="control-label mb-1">Admin</label>
                                                      <select class="form-control" name="admin_id" id="admin_id">
                                                          <option value="{{ $id }}">{{$name}}</option>
                                                      </select>
                                                  </div>
                                                  <div>
                                                      <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                                          <span id="payment-button-amount">Simpan</span>
                                                      </button>
                                                  </div>
                                              </form>
                                            </div>
                                            <div class="tab-pane fade" id="custom-nav-contact" role="tabpanel" aria-labelledby="custom-nav-contact-tab">
                                                <table id="main-data-table" class="table table-striped">
                                                    <thead>
                                                      <tr>
                                                        <th>#</th>
                                                        <th>Nama Sampah</th>
                                                        <th>Kategori Sampah</th>
                                                        <th>Harga</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                      @php
                                                      $i = 1;
                                                      @endphp
                                                      @foreach($trashprice_ontrashed as $trash)
                                                      <tr>
                                                        <td>{{$i++}}</td>
                                                        <td>{{ ucfirst($trash->name) }}.</td>
                                                        <td>{{ ucfirst($trash->trashtype->name) }}</td>
                                                        <td>Rp.{{ $trash->price }}/{{ $trash->unit}}</td>
                                                        <td><span class="badge badge-warning">Dihapus</span></td>
                                                        <td>
                                                            <form method="POST" action="{{route('trashprice.restore', $trash->id)}}">
                                                            @csrf
                                                            <input type="text" name="id" value="{{ $trash->id }}" hidden="true">
                                                            <button class="btn btn-secondary btn-sm" type="submit"><i class="fa fa-reply"></i></button>
                                                            <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#forceDelete{{$trash->id}}"><i class="fa fa-trash"></i></a>
                                                          </form>
                                                        </td>
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

            </div>
        </div>
        <!-- MODAL -->
        @foreach($trashprice as $val)
        <div class="modal fade" id="updateModal{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form action="{{route('trashprice.update', $val->id)}}" method="post" novalidate="novalidate">
                        <div class="modal-header">
                            <h5 class="modal-title" id="mediumModalLabel">Perbarui data {{ ucfirst($val->name)}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                          @csrf
                          @method('PUT')
                          <input type="hidden" name="id" value="{{ $val->id }}">
                          <div class="form-group">
                              <label for="trashtype_id" class="control-label mb-1">Jenis Sampah</label>
                              <select name="trashtype_id" class="form-control @error('trashtype_id') is-invalid @enderror" required>
                                @foreach($trashtype as $trash)
                                    <option value="{{ $trash->id }}" {{ $val->trashtype_id == $trash->id ? 'selected':'' }}>{{ ucfirst($trash->name) }}</option>
                                @endforeach
                              </select>
                          </div>
                          @error('trashtype_id')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                          @enderror
                          <div class="form-group">
                              <label for="name" class="control-label mb-1">Nama Sampah</label>
                              <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Kertas" value="{{ $val->name }}">
                          </div>
                          @error('name')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                          @enderror
                          <div class="row form-group">
                            <div class="col col-md-12">
                                <label for="price" class="control-label mb-1">Harga Sampah</label>
                              <div class="input-group">
                                <div class="input-group-addon">Rp.</div>
                                <input id="price" name="price" type="text" class="form-control @error('price') is-invalid @enderror" aria-required="true" aria-invalid="false" value="{{ $val->price }} ">
                                  <select name="unit" class="input-group-addon" required>

                                    @if($val->unit == 'kg')
                                        <option value="kg" selected>/Kg</option>
                                        <option value="pcs">/Pcs</option>
                                    @else
                                        <option value="kg">/Kg</option>
                                        <option value="pcs" selected>/Pcs</option>
                                    @endif
                                  </select>
                              </div>
                            </div>
                          </div>
                          @error('price')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                          @enderror
                          <div class="form-group">
                            <label for="status" class="control-label mb-1">Status</label>
                              <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                @if($val->status == '1')
                                    <option value="1" selected>Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                @else
                                    <option value="1">Aktif</option>
                                    <option value="0" selected>Tidak Aktif</option>
                                @endif
                              </select>
                          </div>
                          @error('status')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                          @enderror
                          <div class="form-group">
                            @php
                                $id = Auth::user()->id;
                                $name = Auth::user()->name;
                            @endphp
                              <label for="admin_id" class="control-label mb-1">Admin</label>
                              <select class="form-control" name="admin_id" id="admin_id">
                                  <option value="{{ $id }}">{{$name}}</option>
                              </select>
                          </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteModal{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <form method="POST" action="{{ route('trashprice.destroy', $val->id)}}">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="mediumModalLabel">Hapus {{ ucfirst($val->name)}} ?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Hapus sampah {{ ucfirst($val->name) }}
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
        @foreach($trashprice_ontrashed as $trash)
        <div class="modal fade" id="forceDelete{{$trash->id}}" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <form method="POST" action="{{ route('trashprice.force', $trash->id)}}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="mediumModalLabel">Hapus permanen {{ ucfirst($trash->name)}} ?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Hapus permanen sampah {{ ucfirst($trash->name) }}
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