<li
    class="nav-item {{ request()->is('senaraiPending') || request()->is('senaraiPendingRombongan') ? 'menu-open' : '' }}">
    <a href="#"
        class="nav-link {{ request()->is('senaraiPending') || request()->is('senaraiPendingRombongan') ? 'active' : '' }}">
        <i class="nav-icon fas fa-list"></i>
        <p>
            Senarai Permohonan
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a class="nav-link  {{ request()->is('senaraiPending') ? ' active' : '' }}"
                href="{{ route('senaraiPending') }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Individu
                </p>
            </a>
        </li>
        <li class="nav-item"><a class="nav-link  {{ request()->is('senaraiPendingRombongan') ? ' active' : '' }}"
                href="{{ route('senaraiPendingRombongan') }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Rombongan</p>
            </a>
        </li>
    </ul>
</li>


<li class="nav-header">KELULUSAN OLEH YB DATO'</li>
<li
    class="nav-item {{ request()->is('senaraiRekodIndividu') || request()->is('senaraiRekodRombongan') ? 'menu-open' : '' }}">
    <a href="#"
        class="nav-link {{ request()->is('senaraiRekodIndividu') || request()->is('senaraiRekodRombongan') ? 'active' : '' }}">
        <i class="nav-icon fas fa-chalkboard"></i>
        <p>
            Rekod Permohonan
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item"><a
                class="nav-link {{ url()->current() == url('senaraiRekodIndividu') ? ' active' : '' }}"
                href="{{ route('senaraiRekodIndividu') }}"><i class="far fa-circle nav-icon"></i>
                <P>Individu</P>
            </a>
        </li>
        <li class="nav-item"><a
                class="nav-link {{ url()->current() == url('/senaraiRekodRombongan') ? ' active' : '' }}"
                href="{{ route('senaraiRekodRombongan') }}"><i class="far fa-circle nav-icon"></i>
                <P>Rombongan</P>
            </a>
        </li>
    </ul>
</li>

<li class="nav-header">PERMOHONAN</li>
<li class="nav-item">
    <a href="{{ route('senaraiPermohonanProses') }}"
        class="nav-link {{ url()->current() == route('senaraiPermohonanProses') ? 'active' : '' }}">
        <i class="nav-icon fas fa-book"></i>
        <p>Permohonan Baru</p>
    </a>
</li>
<li
    class="nav-item {{ url()->current() == url('permohonan-rombongan') ||url()->current() == url('registerFormIndividu', 'rasmi') ||url()->current() == url('registerFormIndividu', 'tidakRasmi') ||url()->current() == url('sertai-rombongan')? 'menu-open': '' }}">
    <a href="#"
        class="nav-link {{ url()->current() == url('permohonan-rombongan') ||url()->current() == url('registerFormIndividu', 'rasmi') ||url()->current() == url('registerFormIndividu', 'tidakRasmi') ||url()->current() == url('sertai-rombongan')? 'active': '' }}">
        <i class="nav-icon fa fa-users"></i>
        <p>Borang
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li
            class="nav-item {{ url()->current() == url('registerFormIndividu', 'rasmi') ||url()->current() == url('registerFormIndividu', 'tidakRasmi') ||url()->current() == url('registerFormIndividuRombongan', Auth::user()->usersID)? 'menu-open': '' }}">
            <a href=" #"
                class="nav-link  {{ url()->current() == url('registerFormIndividu', 'rasmi') ||url()->current() == url('registerFormIndividu', 'tidakRasmi') ||url()->current() == url('registerFormIndividuRombongan', Auth::user()->usersID)? 'active': '' }}">
                <i class="  nav-icon fa fa-user"></i>
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
            class="nav-item {{ url()->current() == route('permohonan-rombongan') || url()->current() == route('sertai-rombongan')? 'menu-open': '' }}">
            <a href="#"
                class="nav-link {{ url()->current() == route('permohonan-rombongan') || url()->current() == route('sertai-rombongan')? 'active': '' }}">
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
<li
    class="nav-item {{ url()->current() == route('keputusan-permohonan') || url()->current() == route('keputusan-rombongan')? 'menu-open': '' }}">
    <a href="#"
        class="nav-link {{ url()->current() == route('keputusan-permohonan') || url()->current() == route('keputusan-rombongan')? 'active': '' }}">
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

<li class="nav-header">LAPORAN</li>
<li class="nav-item {{ request()->is('laporan-*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->is('laporan-*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-vote-yea"></i>
        <p>
            Tahunan
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('laporan-jantina') ? 'active' : '' }}"
                href="{{ url('laporan-jantina?tahun=' . now()->year) }}">
                {{-- <a class="nav-link" href="{{ route('laporanLP') }}"> --}}
                <i class="far fa-circle nav-icon"></i>
                <span>Lelaki & Perempuan</span>
            </a>
        </li>
        <li class="nav-item"><a class="nav-link {{ request()->is('laporan-individu') ? 'active' : '' }}"
                href="{{ url('laporan-individu') }}"><i class="far fa-circle nav-icon"></i>
                <span>Individu</span></a></li>
        <li class="nav-item"><a class="nav-link {{ request()->is('laporan-jabatan') ? 'active' : '' }}"
                href="{{ url('laporan-jabatan?tahun=' . now()->year) }}"><i class="far fa-circle nav-icon"></i>
                <span>Jabatan</span></a></li>
        {{-- <li class="nav-item"><a class="nav-link" href="{{ url('laporan-individu?tahun='.now()->year) }}"><i
                    class="far fa-circle nav-icon"></i> <span>Individu</span></a></li> --}}
        <li class="nav-item"><a class="nav-link {{ request()->is('laporan-negara') ? 'active' : '' }} "
                href="{{ url('laporan-negara?tahun=' . now()->year) }}"><i class="far fa-circle nav-icon"></i>
                <span>Negara</span></a></li>
        {{-- <li class="nav-item"><a class="nav-link {{  request()->is('laporan-jabatan') ? 'active' : '' }}" href="{{ route('laporanViewBG') }}"><i
                    class="far fa-circle nav-icon"></i> <span>Lulus / Gagal</span></a></li> --}}
        <li class="nav-item"><a class="nav-link {{ request()->is('laporan-bulanan') ? 'active' : '' }}"
                href="{{ url('laporan-bulanan?tahun=' . now()->year) }}"><i class="far fa-circle nav-icon"></i>
                <span>Bulanan</span></a></li>
        <li class="nav-item"><a class="nav-link {{ request()->is('laporan-tahunan') ? 'active' : '' }}"
                href="{{ route('laporan-tahunan') }}"><i class="far fa-circle nav-icon"></i> <span>Tahun</span></a>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a href="{{ url('laporanDato') }}" class="nav-link">
        {{-- <i class="nav-icon far fa-circle text-warning"></i> --}}
        <i class="nav-icon fas fa-print"></i>
        <p class="text"> Cetak</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('jumlahKeluarnegara') }}"
        class="nav-link {{ request()->is('jumlahKeluarnegara') ? 'active' : '' }}">
        <i class="nav-icon fas fa-print"></i>
        <p> Jumlah Keluar Negara</p>
    </a>
</li>
<li class="nav-header">PENGGUNA</li>
<li class="nav-item">
    <a href="{{ url('senaraiPengguna') }}"
        class="nav-link {{ request()->is('senaraiPengguna') ? ' active' : '' }}">
        <i class="nav-icon fa fa-user-plus"></i>
        <p class="text">Senarai Pengguna</p>
    </a>
</li>
<li class="nav-item {{ request()->is('daftarPic') || request()->is('senaraiPic') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->is('daftarPic') || request()->is('senaraiPic') ? 'active' : '' }}">
        <i class="nav-icon fas fa-child"></i>
        <p>
            Pic Jabatan
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item"><a class="nav-link {{ request()->is('daftarPic') ? 'active' : '' }}"
                href="{{ route('daftarPic') }}">
                <i class="far fa-circle nav-icon"></i> <span>Daftar</span></a></li>
        <li class="nav-item"><a class="nav-link {{ request()->is('senaraiPic') ? 'active' : '' }}"
                href="{{ route('senaraiPic') }}"><i class="far fa-circle nav-icon"></i> <span>Senarai</span></a>
        </li>
    </ul>
</li>
<li class="nav-header">KONFIGURASI</li>
<li class="nav-item"><a class="nav-link {{ request()->is('senaraiJabatan') ? 'active' : '' }}"
        href="{{ route('senaraiJabatan') }}"><i class="nav-icon fa fa-building"></i> <span>Senarai
            Jabatan</span></a></li>
<li class="nav-item"><a class="nav-link {{ request()->is('senaraiJawatan') ? 'active' : '' }}"
        href="{{ route('senaraiJawatan') }}"><i class="nav-icon fa fa-briefcase"></i> <span>Senarai
            Jawatan</span></a>
</li>
<li class="nav-item"><a class="nav-link {{ request()->is('senaraiGredKod') ? 'active' : '' }}"
        href="{{ route('senaraiGredKod') }}"><i class="nav-icon fa fa-briefcase"></i> <span>Senarai Gred
            Kod</span></a>
</li>
<li class="nav-item"><a class="nav-link {{ request()->is('senaraiGredAngka') ? 'active' : '' }}"
        href="{{ route('senaraiGredAngka') }}"><i class="nav-icon fa fa-briefcase"></i> <span>Senarai Gred
            Angka</span></a>
</li>
<li class="nav-item"><a class="nav-link {{ request()->is('terusDato') ? 'active' : '' }}"
        href="{{ route('terusDato') }}"><i class="nav-icon fa fa-briefcase"></i>
        <span>
            Permohonan Terus SUK
        </span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->is('sokongantsuk') ? 'active' : '' }}" href="{{ route('sokongantsuk') }}">
        <i class="nav-icon fa fa-briefcase"></i>
        <span>
            Sokongan Timbalan SUK
        </span>
    </a>
</li>
<li class="nav-item"><a class="nav-link {{ request()->is('infoSurat') ? 'active' : '' }}"
        href="{{ route('infoSurat') }}"><i class="nav-icon fa fa-briefcase"></i> <span>Maklumat Surat</span></a>
</li>
<li class="nav-header">ADMIN</li>
