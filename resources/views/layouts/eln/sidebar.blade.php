<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
        {{-- <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
        <span class="brand-text text-center font-weight-light">E-Luar Negara</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#"class="d-block hyphens">{{ \Illuminate\Support\Str::limit(Auth::user()->nama, 23, $end='...') }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        {{-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> --}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">MENU PENTADBIR</li>
                <li class="nav-item">
                    <a href="{{ url('/') }}"
                        class="nav-link {{  url()->current() == url('/') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Halaman Utama</p>
                    </a>
                </li>
                @if (Auth::user()->role == 'pengguna')
                    @include('layouts.sidebarMenu')
                @elseif (Auth::user()->role == "adminBPSM")
                    @include('layouts.sidebarMenuAdminBPSM')
                @elseif (Auth::user()->role == "DatoSUK")
                    @include('layouts.sidebarMenuKPP')
                @elseif (Auth::user()->role == "jabatan")
                    @include('layouts.sidebarMenuJabatan')
                @endif
                @if (Auth::user()->role == 'pengguna')
                <li class="nav-item">
                    <a href="{{ url('panduan-pengguna') }}" class="nav-link">
                        <i class="nav-icon fas fa-book-open"></i>
                        <p class="text">Panduan Pengguna</p>
                    </a>
                </li>
                @elseif (Auth::user()->role == "jabatan")
                <li class="nav-item">
                    <a href="{{ url('panduan-penggunaKetua') }}" class="nav-link">
                        <i class="nav-icon fas fa-book-open"></i>
                        <p class="text">Panduan Pengguna</p>
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a href="{{ url('profil') }}" class="nav-link {{ url()->current() == url('profil') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-id-card"></i>
                        <p class="text">Profil</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p class="text">Log Keluar</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
