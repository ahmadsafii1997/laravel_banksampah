
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Aplikasi Bank Sampah Reksa Kepil | Nasabah</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="{{ asset('admin/assets/css/normalize.css')}}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/flag-icon.min.css')}}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/cs-skin-elastic.css')}}">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
    <link rel="stylesheet" href="{{ asset('admin/assets/scss/style.css')}}">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->

</head>
<body class="bg-dark">


    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <br>
            <br>
            <br>
            <div class="login-content">
                <div class="login-logo">
                    <img class="align-content" style="max-width: 40%;" src="{{ asset('admin/images/logoreksakepil.png')}}" alt="">
                </div>
                <br />
                <div class="login-form">
                    <form action="{{route('customer.login')}}" method="post">
                        @csrf

                        <div class="row form-group">
                            <div class="col col-md-12">
                                <label for="cc-payment" class="control-label mb-1">Hak Akses</label>
                              <div class="input-group">
                                <select id="dynamic_select"  class="form-control">
                                    <option value="{{route('customer.login')}}" selected>Nasabah</option>
                                    <option value="{{route('admin.login')}}">Admin</option>
                                    <option value="{{route('director.login')}}">Direktur</option>
                                </select>
                              </select>
                              </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Nama Pengguna Nasabah</label>
                            <input type="text" name="username" class="form-control{{ $errors->has('username') ? ' has-warning' : '' }}" value="{{ old('username') }}" placeholder="Nama Pengguna">
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-12">
                                <label for="cc-payment" class="control-label mb-1">Kata Sandi</label>
                              <div class="input-group">
                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Kata Sandi" required>
                                <a class="input-group-addon" onclick="myFunction()" data-toggle="tooltip" title="Lihat kata sandi"><i class="fa fa-eye"></i></a>
                              </div>
                            </div>
                        </div>
                        
                        @if ($message = Session::get('error'))
                            <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                
                                    {{ $message }}
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Masuk</button>

                        
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('admin/assets/js/vendor/jquery-2.1.4.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="{{ asset('admin/assets/js/plugins.js')}}"></script>
    <script src="{{ asset('admin/assets/js/main.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

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

    <script type="text/javascript">
        $(function() {
          // bind change event to select
          $('#dynamic_select').on('change', function() {
            var url = $(this).val(); // get selected value
            if (url) { // require a URL
              window.location = url; // redirect
            }
            return false;
          });
        });
    </script>
</body>
</html>
