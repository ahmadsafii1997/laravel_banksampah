 <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href=""><img src="{{ asset('admin/images/logoreksakepil.png')}}" style="max-width: 50%;" alt="Logo"></a>
                <a class="navbar-brand hidden" href=""><img src="{{ asset('admin/images/logo2.png')}}" alt="Logo"></a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="{{url('director/home')}}"> <i class="menu-icon ti-home"></i>Beranda </a>
                    </li>
                    <h3 class="menu-title"></h3><!-- /.menu-title -->
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon ti-wallet"></i>Data Transaksi</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><a href="{{url('director/transaction')}}">Transaksi Sampah</a></li>
                            <li><a href="{{url('director/earning')}}">Saldo</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon ti-user"></i>Data Pengguna</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><a href="{{url('director/admin')}}">Data Administrator</a></li>
                            <li><a href="{{url('director/director')}}">Data Direktur</a></li>
                            <li><a href="{{url('director/customer')}}">Data Nasabah</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i>Data Sampah</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><a href="{{url('director/trashtype')}}">Jenis Sampah</a></li>
                            <li><a href="{{url('director/trashprice')}}">Harga Sampah</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('director.logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"> <i class="menu-icon fa fa-sign-out"></i>Keluar </a><form id="logout-form" action="{{ route('director.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
