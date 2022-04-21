<!-- FUNGSI EXTENDS DIGUNAKAN UNTUK ME-LOAD MASTER LAYOUTS YANG ADA, KARENA INI ADALAH HALAMAN HOME MAKA KITA ME-LOAD LAYOUTS ADMIN.BLADE.PHP -->
<!-- KETIKA MELOAD FILE BLADE, MAKA EKSTENSI .BLADE.PHP TIDAK PERLU DITULISKAN -->
@extends('admin.layouts.layout')

<!-- TAG YANG DIAPIT OLEH SECTION('TITLE') AKAN ME-REPLACE @YIELD('TITLE') PADA MASTER LAYOUTS -->
@section('title')
    <title>Data Nasabah | Admin</title>
@endsection

<!-- TAG YANG DIAPIT OLEH SECTION('CONTENT') AKAN ME-REPLACE @YIELD('CONTENT') PADA MASTER LAYOUTS -->
@section('content')
<main class="main">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Data Pengguna</li>
        <li class="breadcrumb-item active">Nasabah</li>
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
                                      <strong class="card-title" v-if="headerText">Data Nasabah</strong>
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
                                            <table id="example" class="table table-striped dt-responsive nowrap" style="width:100%">
                                                <thead>
                                                  <tr>
                                                    <th>#</th>
                                                    <th>Nama</th>
                                                    <th>NIK</th>
                                                    <th>Nomor Telepon</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  @php
                                                    $i = 1;
                                                  @endphp
                                                  @foreach($customers as $val)
                                                  <tr>
                                                    <td>{{ $i++}}.</td>
                                                      <td>{{ ucfirst($val->name )}}</td>
                                                      <td><a href="{{ route('customer.show', $val->id)}}"><span class="badge badge-primary">{{ $val->nik}}</span></a></td>
                                                      @if($val->phone != null)
                                                        <td>{{ ucfirst($val->phone )}}</td>
                                                      @else
                                                        <td><span class="badge badge-secondary">Tidak Ada Nomor Telepon</span></td>
                                                      @endif
                                                      @if($val->status == 1)
                                                        <td><span class="badge badge-primary">Aktif</span></td>
                                                      @else
                                                        <td><span class="badge badge-secondary">Tidak Aktif</span></td>
                                                      @endif
                                                      <td>
                                                          <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#updateModal{{$val->id}}"><i class="fa fa-pencil"></i></button>
                                                          <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{$val->id}}"><i class="fa fa-trash"></i></button>
                                                          <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#passwordModal{{$val->id}}"><i class="fa fa-key"></i></button>
                                                      </td>
                                                  </tr>
                                                  @endforeach
                                                </tbody>
                                            </table>
                                          </div>

                                          <div class="tab-pane fade" id="custom-nav-profile" role="tabpanel" aria-labelledby="custom-nav-profile-tab">
                                              <form action="{{route('customer.store')}}" method="post" novalidate="novalidate">
                                                  @csrf
                                                <div class="form-group">
                                                    <label for="nik" class="control-label mb-1">NIK Nasabah</label>
                                                    <input id="nik" name="nik" type="text" class="form-control @error('nik') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="NIK Nasabah" value="{{old('nik')}}">
                                                </div>
                                                @error('nik')
                                                  <div class="alert alert-danger" role="alert">
                                                      {{ $message }}
                                                  </div>
                                                @enderror
                                                <div class="form-group">
                                                    <label for="name" class="control-label mb-1">Nama Nasabah</label>
                                                    <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Nama Nasabah" value="{{old('name')}}">
                                                </div>
                                                @error('name')
                                                  <div class="alert alert-danger" role="alert">
                                                      {{ $message }}
                                                  </div>
                                                @enderror
                                                <div class="form-group">
                                                    <label for="username" class="control-label mb-1">Nama Pengguna</label>
                                                    <input id="username" name="username" type="text" class="form-control @error('username') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Nama Pengguna" value="{{old('username')}}">
                                                </div>
                                                @error('username')
                                                  <div class="alert alert-danger" role="alert">
                                                      {{ $message }}
                                                  </div>
                                                @enderror
                                                <div class="form-group">
                                                    <label for="address" class="control-label mb-1">Alamat Nasabah</label>
                                                    <textarea id="address" name="address" class="form-control @error('address') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Alamat Nasabah" value="{{old('address')}}">{{old('address')}}</textarea>
                                                </div>
                                                @error('address')
                                                  <div class="alert alert-danger" role="alert">
                                                      {{ $message }}
                                                  </div>
                                                @enderror
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-1">Nomor Telepon</label>
                                                    <input id="phone" name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Nomor Telepon" value="{{old('phone')}}">
                                                </div>
                                                @error('phone')
                                                  <div class="alert alert-danger" role="alert">
                                                      {{ $message }}
                                                  </div>
                                                @enderror
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
                                                      <th>Nama</th>
                                                      <th>Nomor Telepon</th>
                                                      <th>Status</th>
                                                      <th>Aksi</th>
                                                    </tr>
                                                  </thead>
                                                  <tbody>
                                                    @php
                                                    $i = 1;
                                                    @endphp
                                                    @foreach($customer_ontrashed as $trash)
                                                    <tr>
                                                      <td>{{$i++}}.</td>
                                                      <td>{{ ucfirst($trash->name) }}</td>
                                                      @if($trash->phone != null)
                                                      <td>{{ ucfirst($trash->phone )}}</td>
                                                      @else
                                                      <td><span class="badge badge-secondary">Tidak Ada Nomor Telepon</span></td>
                                                      @endif
                                                      <td><span class="badge badge-warning">Dihapus</span></td>
                                                      <td>
                                                        <form method="POST" action="{{route('customer.restore', $trash->id)}}">
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
                        </div><!-- .animated -->
                    </div><!-- .content -->

                </div>

            </div>
        </div>
        <!-- MODAL -->
        @foreach($customers as $val)
        <div class="modal fade" id="updateModal{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form action="{{route('customer.update', $val->id)}}" method="post" novalidate="novalidate">
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
                              <label for="nik" class="control-label mb-1">NIK Nasabah</label>
                              <input id="nik" name="nik" type="text" class="form-control @error('nik') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="NIK Nasabah" value="{{ $val->nik }}">
                          </div>
                          @error('nik')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                          @enderror
                          <div class="form-group">
                              <label for="name" class="control-label mb-1">Nama Nasabah</label>
                              <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Nama Nasabah" value="{{ ucfirst($val->name)}}">
                          </div>
                          @error('name')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                          @enderror
                          <div class="form-group">
                              <label for="username" class="control-label mb-1">Nama Pengguna</label>
                              <input id="username" name="username" type="text" class="form-control @error('username') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Nama Pengguna" value="{{$val->username}}">
                          </div>
                          @error('username')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                          @enderror
                          <div class="form-group">
                              <label for="address" class="control-label mb-1">Alamat Nasabah</label>
                              <textarea id="address" name="address" class="form-control @error('address') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Alamat Nasabah" value="{{ $val->address }}">{{ ucfirst($val->address)}}</textarea>
                          </div>
                          @error('address')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                          @enderror
                          <div class="form-group">
                              <label for="phone" class="control-label mb-1">Nomor Telepon</label>
                              <input id="phone" name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Nomor Telepon" value="{{ $val->phone}}">
                          </div>
                          @error('phone')
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
                  <form method="POST" action="{{ route('customer.destroy', $val->id)}}">
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
                            Hapus Nasabah {{ ucfirst($val->name) }}
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

        <div class="modal fade" id="passwordModal{{$val->id}}" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form action="{{route('customer.update.password', $val->id)}}" method="post" novalidate="novalidate">
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
                              <label for="password" class="control-label mb-1">Kata Sandi</label>
                              <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Kata Sandi">
                          </div>
                          @error('password')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                          @enderror
                          <div class="form-group">
                              <label for="password" class="control-label mb-1">Ulang Kata Sandi</label>
                              <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi kata sandi">
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
        @endforeach
        @foreach($customer_ontrashed as $trash)
        <div class="modal fade" id="forceDelete{{$trash->id}}" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form method="POST" action="{{route('customer.force', $trash->id)}}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $trash->id}}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="mediumModalLabel">Hapus permanen {{ ucfirst($trash->name)}} ?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Hapus permanen Nasabah {{ ucfirst($trash->name) }}
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