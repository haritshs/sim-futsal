<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <span class="brand-text font-weight-light">Primavera Futsal</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('template2/dist/img/avatar5.png')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::guard('admin')->user()->name }} - {{ Auth::guard('admin')->user()->role }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->

                @if(Auth::guard('admin')->user()->role == 'karyawan')
                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fa fa-circle-o"></i>
                        <p>
                        KARYAWAN
                        <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                       
                        <li class="nav-item">
                            <a href=" {{ route('kehadiran.index') }} " class="nav-link ">
                                <i class="fa fa-car nav-icon"></i>
                                <p>Absensi</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                @if(Auth::guard('admin')->user()->role == 'admin')
                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fa fa-circle-o"></i>
                        <p>
                        MASTER
                        <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        
                        <li class="nav-item">
                            <a href=" {{ route('user.index') }} " class="nav-link  ">
                                <i class="fa fa-users nav-icon"></i>
                                <p>Data Pelanggan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href=" {{ route('lapangan.index') }} " class="nav-link ">
                                <i class="fa  fa-futbol  nav-icon"></i>
                                <p>Data Lapangan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href=" {{ route('turnamen.index') }} " class="nav-link ">
                                <i class="fa fa-calendar nav-icon"></i>
                                <p>Data Turnamen</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href=" {{ route('sparing.index') }} " class="nav-link ">
                                <i class="fa fa-trophy nav-icon"></i>
                                <p>Data Sparing</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('tim.index') }}" class="nav-link ">
                                <i class="fa fa-database nav-icon"></i>
                                <p>Data Tim Futsal</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href=" {{ route('voucher.index') }} " class="nav-link ">
                                <i class="fa fa-credit-card nav-icon"></i>
                                <p>Voucher</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fa fa-circle-o"></i>
                        <p>
                        TRANSAKSI
                        <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href=" {{ url('admin/booking') }} " class="nav-link  ">
                                <i class="fa fa-book nav-icon"></i>
                                <p>Bookings</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                
                @if(Auth::guard('admin')->user()->role == 'superAdmin')
                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fa fa-circle-o"></i>
                        <p>
                        MASTER
                        <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        
                        <li class="nav-item">
                            <a href=" {{ route('user.index') }} " class="nav-link  ">
                                <i class="fa fa-users nav-icon"></i>
                                <p>Data Pelanggan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href=" {{ route('lapangan.index') }} " class="nav-link ">
                                <i class="fa  fa-futbol  nav-icon"></i>
                                <p>Data Lapangan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href=" {{ route('turnamen.index') }} " class="nav-link ">
                                <i class="fa fa-calendar nav-icon"></i>
                                <p>Data Turnamen</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href=" {{ route('sparing.index') }} " class="nav-link ">
                                <i class="fa fa-trophy nav-icon"></i>
                                <p>Data Sparing</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('tim.index') }}" class="nav-link ">
                                <i class="fa fa-database nav-icon"></i>
                                <p>Data Tim Futsal</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href=" {{ route('voucher.index') }} " class="nav-link ">
                                <i class="fa fa-credit-card nav-icon"></i>
                                <p>Voucher</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fa fa-circle-o"></i>
                        <p>
                        TRANSAKSI
                        <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href=" {{ url('admin/booking') }} " class="nav-link  ">
                                <i class="fa fa-book nav-icon"></i>
                                <p>Bookings</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fa fa-circle-o"></i>
                        <p>
                        KARYAWAN
                        <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href=" {{ route('karyawan.index') }} " class="nav-link ">
                                <i class="fa fa-user-circle nav-icon"></i>
                                <p>Data Karyawan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href=" {{ route('kehadiran.index') }} " class="nav-link ">
                                <i class="fa fa-car nav-icon"></i>
                                <p>Data Kehadiran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href=" {{ route('penggajian.index') }} " class="nav-link ">
                                <i class="fa fa-envelope nav-icon"></i>
                                <p>Penggajian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href=" {{ route('jabatan.index') }} " class="nav-link ">
                                <i class="fa fa-male nav-icon"></i>
                                <p>Data Jabatan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href=" {{ route('shift.index') }} " class="nav-link ">
                                <i class="fa fa-male nav-icon"></i>
                                <p>Data Shift</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href=" {{ route('pendapatan.index') }} " class="nav-link ">
                                <i class="fa fa-shopping-bag nav-icon"></i>
                                <p>Data Pendapatan</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fa fa-circle-o"></i>
                        <p>
                        LAPORAN
                        <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('admin/pengeluaran') }}" class="nav-link ">
                                <i class="fa fa-file nav-icon"></i>
                                <p>Pengeluaran</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('admin/laporan') }}" class="nav-link ">
                                <i class="fa fa-save nav-icon"></i>
                                <p>Transaksi</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
        <!-- /.sidebar -->
</aside>