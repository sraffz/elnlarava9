        <li class="nav-header">SENARAI PERMOHONAN</li>
        {{-- <li class="nav-header">KELULUSAN PERMOHONAN YB DATO'</li> --}}
        <li
            class="nav-item {{ request()->is('senarai-semak') || request()->is('senaraiRombonganKetua') ? 'menu-open' : '' }}">
            <a href="#"
                class="nav-link {{ request()->is('senarai-semak') || request()->is('senaraiRombonganKetua') ? 'active' : '' }}">
                <i class="nav-icon fas fa-list"></i>
                <p> Senarai Permohonan
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('senarai-semak') }}"
                        class="nav-link {{ request()->is('senarai-semak') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Individu</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('senaraiRombonganKetua') }}"
                        class="nav-link {{ request()->is('senaraiRombonganKetua') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Rombongan</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item {{ request()->is('senaraiRekod*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('senaraiRekod*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-chalkboard"></i>
                <p>
                    Rekod Permohonan
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('senaraiRekodIndividu') }}"
                        class="nav-link {{ request()->is('senaraiRekodIndividu') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Individu</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('senaraiRekodRombongan') }}"
                        class="nav-link {{ request()->is('senaraiRekodRombongan') ? 'active' : '' }}">
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
                <li class="nav-item"><a
                        class="nav-link {{ request()->is('laporan-individu') ? 'active' : '' }}"
                        href="{{ url('laporan-individu') }}"><i class="far fa-circle nav-icon"></i>
                        <span>Individu</span></a></li>
                <li class="nav-item"><a class="nav-link {{ request()->is('laporan-jabatan') ? 'active' : '' }}"
                        href="{{ url('laporan-jabatan?tahun=' . now()->year) }}"><i
                            class="far fa-circle nav-icon"></i>
                        <span>Jabatan</span></a></li>
                {{-- <li class="nav-item"><a class="nav-link" href="{{ url('laporan-individu?tahun='.now()->year) }}"><i
                            class="far fa-circle nav-icon"></i> <span>Individu</span></a></li> --}}
                <li class="nav-item"><a class="nav-link {{ request()->is('laporan-negara') ? 'active' : '' }} "
                        href="{{ url('laporan-negara?tahun=' . now()->year) }}"><i
                            class="far fa-circle nav-icon"></i>
                        <span>Negara</span></a></li>
                {{-- <li class="nav-item"><a class="nav-link {{  request()->is('laporan-jabatan') ? 'active' : '' }}" href="{{ route('laporanViewBG') }}"><i
                            class="far fa-circle nav-icon"></i> <span>Lulus / Gagal</span></a></li> --}}
                <li class="nav-item"><a class="nav-link {{ request()->is('laporan-bulanan') ? 'active' : '' }}"
                        href="{{ url('laporan-bulanan?tahun=' . now()->year) }}"><i
                            class="far fa-circle nav-icon"></i>
                        <span>Bulanan</span></a></li>
                <li class="nav-item"><a class="nav-link {{ request()->is('laporan-tahunan') ? 'active' : '' }}"
                        href="{{ route('laporan-tahunan') }}"><i class="far fa-circle nav-icon"></i>
                        <span>Tahun</span></a></li>
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
