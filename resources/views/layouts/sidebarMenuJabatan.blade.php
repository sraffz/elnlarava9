{{-- <li class="nav-item ">
    <a class="nav-link  {{ url()->current() == url('senaraiPermohonanJabatan') ? 'active' : '' }}"
        href="{{ route('senaraiPermohonanJabatan') }}">
        <i class="nav-icon fa fa-link"></i>
        <P>Permohonan Baru</P>
    </a>
</li> --}}
<li class="nav-header">PERMOHONAN DARI JABATAN</li>

<li
    class="nav-item {{ url()->current() == url('senaraiPermohonanJabatan') || url()->current() == url('senaraiPendingRombongan') ? 'menu-open' : '' }}">
    <a href="#"
        class="nav-link  {{ url()->current() == url('senaraiPermohonanJabatan') || url()->current() == url('senaraiPendingRombongan') ? 'active' : '' }}">
        <i class="nav-icon fas fa-list"></i>
        <p>
            Senarai Permohonan
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a class="nav-link  {{ url()->current() == url('senaraiPermohonanJabatan') ? 'active' : '' }}"
                href="{{ route('senaraiPermohonanJabatan') }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Individu
                </p>
            </a>
        </li>
        <li class="nav-item"><a
                class="nav-link  {{ url()->current() == url('senaraiPendingRombongan') ? 'active' : '' }}"
                href="{{ route('senaraiPendingRombongan') }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Rombongan</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a class="nav-link  {{ url()->current() == url('rekod-permohonan') ? 'active' : '' }}"
        href="{{ route('senaraiPermohonanLepas') }}">
        <i class="nav-icon fas fa-chalkboard"></i>
        <P>Keputusan Permohonan</P>
    </a>
</li>
<li class="nav-header">PERMOHONAN</li>

<li
    class="nav-item {{ url()->current() == url('permohonan-rombongan') || url()->current() == url('registerFormIndividu', 'rasmi') || url()->current() == url('registerFormIndividu', 'tidakRasmi') || url()->current() == url('sertai-rombongan') ? 'menu-open' : '' }}">
    <a href="#"
        class="nav-link {{ url()->current() == url('permohonan-rombongan') || url()->current() == url('registerFormIndividu', 'rasmi') || url()->current() == url('registerFormIndividu', 'tidakRasmi') || url()->current() == url('sertai-rombongan') ? 'active' : '' }}">
        <i class="nav-icon fa fa-users"></i>
        <p>Borang
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li
            class="nav-item {{ url()->current() == url('registerFormIndividu', 'rasmi') || url()->current() == url('registerFormIndividu', 'tidakRasmi') ? 'menu-open' : '' }}">
            <a href=" #"
                class="nav-link  {{ url()->current() == url('registerFormIndividu', 'rasmi') || url()->current() == url('registerFormIndividu', 'tidakRasmi') ? 'active' : '' }}">
                <i class=" nav-icon fa fa-user"></i>
                <p>Individu
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a class="nav-link  {{ url()->current() == url('registerFormIndividu', 'rasmi') ? 'active' : '' }}"
                        href="{{ route('registerFormIndividu', 'rasmi') }}"><i
                            class="nav-icon far fa-circle nav-icon"></i>Rasmi</a>
                </li>
                <li class="nav-item"><a
                        class="nav-link  {{ url()->current() == url('registerFormIndividu', 'tidakRasmi') ? 'active' : '' }}"
                        href="{{ route('registerFormIndividu', 'tidakRasmi') }}"><i
                            class="nav-icon far fa-circle nav-icon"></i>Tidak Rasmi</a></li>
                {{-- <li class="nav-item"><a href="#" data-toggle="tooltip" title="Permohonan secara blanket aproval untuk individu" data-placement="right"><i class="nav-icon fa fa-child"></i>Blanket Aproval</a></li> --}}
            </ul>
        </li>

        <li
            class="nav-item {{ url()->current() == route('permohonan-rombongan') || url()->current() == route('sertai-rombongan') ? 'menu-open' : '' }}">
            <a href="#"
                class="nav-link {{ url()->current() == route('permohonan-rombongan') || url()->current() == route('sertai-rombongan') ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i>
                <p>
                    Rombongan
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('permohonan-rombongan') }}"
                        class="nav-link {{ url()->current() == route('permohonan-rombongan') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Permohonan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('sertai-rombongan') }}"
                        class="nav-link {{ url()->current() == route('sertai-rombongan') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Sertai Rombongan</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a href="{{ route('senaraiPermohonanProses') }}"
        class="nav-link {{ url()->current() == route('senaraiPermohonanProses') ? 'active' : '' }}">
        <i class="nav-icon fas fa-book"></i>
        <p>Permohonan Baru</p>
    </a>
</li>
<li
    class="nav-item {{ url()->current() == route('keputusan-permohonan') || url()->current() == route('keputusan-rombongan') ? 'menu-open' : '' }}">
    <a href="#"
        class="nav-link {{ url()->current() == route('keputusan-permohonan') || url()->current() == route('keputusan-rombongan') ? 'active' : '' }}">
        <i class="nav-icon fas fa-chalkboard"></i>
        <p>
            Keputusan
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('keputusan-permohonan') }}"
                class="nav-link {{ url()->current() == route('keputusan-permohonan') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Individu</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('keputusan-rombongan') }}"
                class="nav-link {{ url()->current() == route('keputusan-rombongan') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Rombongan</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-header">PENGGUNA</li>
