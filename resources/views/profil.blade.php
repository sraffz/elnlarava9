@extends('layouts.eln', ['activePage' => 'profil'])

@section('title', 'Maklumat Diri')

@section('link')

@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profil Pengguna</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Halaman Utama</a></li>
                        <li class="breadcrumb-item active">Profil Pengguna</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="card card-danger card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" alt="User profile picture">
                                {{-- <img class="profile-user-img img-fluid img-circle" src="{{ url('storage/app/public/img/profil/user.jpg') }}" alt="User profile picture"> --}}
                            </div>
                            <h3 class="profile-username text-center">{{ $user->nama }}</h3>
                            <p class="text-muted text-center">{{ $user->nokp }}</p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- About Me Box -->
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Maklumat Diri</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-book mr-1"></i> Email</strong>
                            <p class="text-muted">
                                {{ $user->email }}
                            </p>
                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Jawatan & Gred</strong>
                            <p class="text-muted">
                                {{ $user->userJawatan->namaJawatan }}
                                ({{ $user->userGredKod->gred_kod_abjad }}{{ $user->userGredAngka->gred_angka_nombor }}) <br>
                                ({{ $user->taraf }})
                            </p>
                            <hr>
                            <strong><i class="fas fa-pencil-alt mr-1"></i> Peranan</strong>
                            <p class="text-muted">
                                @if ($user->role == 'jabatan')
                                    Ketua Jabatan
                                @elseif ($user->role == 'pengguna')
                                    Pengguna <br> <a href="{{ route('perananKetuaJabatan') }}">(Borang Peranan Ketua Jabatan)</a>
                                @else
                                    {{ $user->role }}
                                @endif
                            </p>
                            <hr>
                            <strong><i class="far fa-file-alt mr-1"></i> Jabatan</strong>
                            <p class="text-muted">
                                {{ $user->userJabatan->nama_jabatan }} ({{ $user->userJabatan->kod_jabatan }})
                            </p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    @if (Session::has('message'))
                        <div class="alert {{ Session::get('alert-class', 'alert-success') }} alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert"
                                aria-hidden="true">&times;</button>
                            <i class="icon fas fa-check"></i> {{ Session::get('message') }}
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#activity"
                                        data-toggle="tab">Negara</a></li>
                                <li class="nav-item"><a class="nav-link" href="#settings"
                                        data-toggle="tab">Kemaskini</a></li>
                                <li class="nav-item"><a class="nav-link" href="#password" data-toggle="tab">Kata
                                        Laluan</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <!-- Post -->
                                    <div class="post">
                                        <div class="user-block">
                                            <h3 class="text-danger"><strong>Negara Pernah Dikunjungi:</strong></h3>
                                        </div>
                                        <!-- /.user-block -->
                                        <p>
                                            <h5>Individu</h5>
                                        <ul>
                                            @foreach ($senaraiNegara as $senaraiNegaras)
                                                <li>{{ $senaraiNegaras }}</li>
                                            @endforeach
                                        </ul>
                                        <h5>Rombongan</h5>
                                        <ul>
                                            @foreach ($senaraiNegaraRom as $senaraiNegaras)
                                                <li>{{ $senaraiNegaras }}</li>
                                            @endforeach
                                        </ul>
                                        </p>
                                    </div>
                                    <!-- /.post -->
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="settings">
                                    <form class="form-horizontal" method="POST" action="{{ url('kemaskini-profil') }}">
                                        {{ csrf_field() }}
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">Nama</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputName" placeholder="Name"
                                                    name="nama" value="{{ $user->nama }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputkp" class="col-sm-2 col-form-label">No Kad Pengenalan</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputkp" placeholder="kp"
                                                    name="kp" value="{{ $user->nokp }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" name="email" class="form-control" id="inputEmail"
                                                    placeholder="Email" value="{{ $user->email }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="jawatan" class="col-sm-2 col-form-label">Jawatan & Gred</label>
                                            <div class="col-sm-6">
                                                <select class="form-control select2bs4" name="jawatan" id="jawatan"
                                                    required>
                                                    <option value="">Sila Pilih</option>
                                                    @foreach ($jawatan as $jwtn)
                                                        <option value="{{ $jwtn->idJawatan }}"
                                                            {{ $jwtn->idJawatan == $user->jawatan ? 'selected' : '' }}>
                                                            {{ $jwtn->namaJawatan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-2">
                                                <select class="form-control select2bs4" name="gredKod" id="gredKod"
                                                    required>
                                                    <option value="">Sila Pilih</option>
                                                    @foreach ($gredKod as $kodg)
                                                        <option value="{{ $kodg->gred_kod_ID }}"
                                                            {{ $kodg->gred_kod_ID == $user->gredKod ? 'selected' : '' }}>
                                                            {{ $kodg->gred_kod_abjad }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-2">
                                                <select class="form-control select2bs4" name="gredangka" id="gredangka"
                                                    required>
                                                    <option value="">Sila Pilih</option>
                                                    @foreach ($gredAngka as $gred)
                                                        <option value="{{ $gred->gred_angka_ID }}"
                                                            {{ $gred->gred_angka_ID == $user->gredAngka ? 'selected' : '' }}>
                                                            {{ $gred->gred_angka_nombor }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" for="taraf">Taraf</label>
                                            <div class="col-sm-10">
                                                <select name="taraf" id="taraf" class="form-control {{ $errors->has('taraf') ? ' is-invalid' : '' }} select2bs4" required>
                                                    <option value="">Pilih Taraf</option>
                                                    <option value="Tetap" {{ $user->taraf == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                                                    <option value="Jawatan Berasaskan Caruman (JBC)" {{ $user->taraf == 'Jawatan Berasaskan Caruman (JBC)' ? 'selected' : '' }}>Jawatan Berasaskan Caruman (JBC)</option>
                                                    <option value="Sementara" {{ $user->taraf == 'Sementara' ? 'selected' : '' }}>Sementara</option>
                                                    <option value="Contract Of Service (COS)" {{ $user->taraf == 'Contract Of Service (COS)' ? 'selected' : '' }}>Contract Of Service (COS)</option>
                                                    <option value="Contract For Service (CFS)" {{ $user->taraf == 'Contract For Service (CFS)' ? 'selected' : '' }}>Contract For Service (CFS)</option>
                                                    <option value="Berelaun" {{ $user->taraf == 'Berelaun' ? 'selected' : '' }}>Berelaun</option>
                                                    <option value="Sambilan" {{ $user->taraf == 'Sambilan' ? 'selected' : '' }}>Sambilan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" for="jabatan">Jabatan</label>
                                            <div class="col-sm-10">
                                                <select class="form-control select2bs4" name="jabatan" id="jabatan"
                                                    required>
                                                    <option value="">Sila Pilih</option>
                                                    @foreach ($jabatan as $jbtn)
                                                        <option value="{{ $jbtn->jabatan_id }}"
                                                            {{ $jbtn->jabatan_id == $user->jabatan ? 'selected' : '' }}>
                                                            {{ $jbtn->nama_jabatan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Kemaskini</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="password">
                                    <form class="form-horizontal" method="POST"
                                        action="{{ url('kemaskini-katalaluan') }}">
                                        {{ csrf_field() }}
                                        @foreach ($errors->all() as $error)
                                            <p class="text-danger">{{ $error }}</p>
                                        @endforeach
                                        <div class="form-group row">
                                            <label for="currentpass" class="col-sm-3 col-form-label">Kata laluan
                                                Sekarang</label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" id="currentpass"
                                                    placeholder="Kata laluan Sekarang" name="password" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="newpass" class="col-sm-3 col-form-label">Kata laluan Baru</label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" id="newpass"
                                                    placeholder="Kata laluan Baru" name="newpassword" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="confirmnewpass" class="col-sm-3 col-form-label">Sahkan Kata laluan
                                                Baru</label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" id="confirmpass"
                                                    placeholder="Sahkan Kata laluan Baru" name="confirmpassword" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-5 col-sm-6">
                                                <button type="submit" class="btn btn-danger">Tukar Kata Laluan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection
