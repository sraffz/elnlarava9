@php
$url = url()->current();
@endphp
<li class="nav-header">PERMOHONAN</li>
<li
    class="nav-item {{ $url == route('registerFormIndividu', 'tidakRasmi') || $url == route('registerFormIndividu', 'rasmi') ? 'menu-open' : '' }}">
    <a href="#"
        class="nav-link {{ $url == route('registerFormIndividu', 'tidakRasmi') || $url == route('registerFormIndividu', 'rasmi') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user"></i>
        <p>
            Individu
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('registerFormIndividu', 'rasmi') }}"
                class="nav-link {{ $url == route('registerFormIndividu', 'rasmi') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Rasmi</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('registerFormIndividu', 'tidakRasmi') }}"
                class="nav-link {{ $url == route('registerFormIndividu', 'tidakRasmi') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Tidak Rasmi</p>
            </a>
        </li>
    </ul>
</li>
<li
    class="nav-item {{ $url == route('permohonan-rombongan') || $url == route('sertai-rombongan') ? 'menu-open' : '' }}">
    <a href="#"
        class="nav-link {{ $url == route('permohonan-rombongan') || $url == route('sertai-rombongan') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>
            Rombongan
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('permohonan-rombongan') }}"
                class="nav-link {{ $url == route('permohonan-rombongan') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Permohonan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('sertai-rombongan') }}"
                class="nav-link {{ $url == route('sertai-rombongan') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Sertai Rombongan</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-header">SENARAI & KEPUTUSAN</li>
<li class="nav-item">
    <a href="{{ route('senaraiPermohonanProses') }}"
        class="nav-link {{ $url == route('senaraiPermohonanProses') ? 'active' : '' }}">
        <i class="nav-icon fas fa-book"></i>
        <p>Permohonan Baru</p>
    </a>
</li>
<li
    class="nav-item {{ $url == route('keputusan-permohonan') || $url == route('keputusan-rombongan') ? 'menu-open' : '' }}">
    <a href="#"
        class="nav-link {{ $url == route('keputusan-permohonan') || $url == route('keputusan-rombongan') ? 'active' : '' }}">
        <i class="nav-icon fas fa-chalkboard"></i>
        <p>
            Keputusan
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('keputusan-permohonan') }}"
                class="nav-link {{ $url == route('keputusan-permohonan') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Individu</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('keputusan-rombongan') }}"
                class="nav-link {{ $url == route('keputusan-rombongan') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Rombongan</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-header">PENGGUNA</li>
