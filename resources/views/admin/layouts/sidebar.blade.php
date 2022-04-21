 <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href=""><img src="{{ asset('admin/images/logoreksakepil.png')}}" style="max-width: 50%;" alt="Logo"></a>
                <a class="navbar-brand hidden" href="">RK</a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="{{route('admin.home')}}"> <i class="menu-icon ti-home"></i>Beranda </a>
                    </li>
                    <h3 class="menu-title"></h3><!-- /.menu-title -->
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon ti-wallet"></i>Data Transaksi</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><a href="{{route('transaction.index')}}">Transaksi Sampah</a></li>
                            <li><a href="{{route('transaction.earning')}}">Saldo</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon ti-user"></i>Manajemen Pengguna</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><a href="{{route('admin.index')}}">Administrator</a></li>
                            <li><a href="{{route('director.index')}}">Direktur</a></li>
                            <li><a href="{{route('customer.index')}}">Nasabah</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i>Manajemen Sampah</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><a href="{{route('trashtype.index')}}">Jenis Sampah</a></li>
                            <li><a href="{{route('trashprice.index')}}">Daftar Harga</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('admin.logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"> <i class="menu-icon fa fa-sign-out"></i>Keluar </a><form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>