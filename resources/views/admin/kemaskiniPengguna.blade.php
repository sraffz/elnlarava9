@extends('layouts.eln')

@section('title', 'Kemaskini maklumat pengguna')

@section('link')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kemaskini Pengguna</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">kemaskini Pengguna</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                {{-- <div class="col-md-2">
                </div> --}}
                <div class="col-md-12">
                    @include('flash::message')
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                             Kemaskini Butiran Pengguna 
                        </div>
                        <div class="card-body">
                            {!! Form::open(['method' => 'POST', 'url' => 'kemaskiniDataPengguna']) !!}
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>Nama</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        value="{{ $users->nama }}" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>No KP (Username)</label>
                                        <div class="input-group">
                                            <input class="form-control" value="{{ $users->nokp }}" disabled>
                                            <input type="hidden" id="nokp" name="nokp" value="{{ $users->nokp }}"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Peranan</label>
                                        <div class="input-group">
                                            <select style="width: 100%;" id="role" class="form-control select2bs4" name="role" required>
                                                <option value="">Sila Pilih</option>
                                                <option value="jabatan" {{ $users->role == 'jabatan' ? 'selected' : '' }}>Ketua Jabatan</option>
                                                <option value="adminBPSM" {{ $users->role == 'adminBPSM' ? 'selected' : '' }}>Pentadbir PSM</option>
                                                <option value="DatoSUK" {{ $users->role == 'DatoSUK' ? 'selected' : '' }}>Dato SUK</option>
                                                <option value="pengguna" {{ $users->role == 'pengguna' ? 'selected' : '' }}>Pengguna</option>
                                            </select>{{-- {{$k->anugerah}} --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <div class="input-group">
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ $users->email }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Jabatan</label>
                                        <select class="form-control select2bs4" name="jabatan" style="width: 100%;"
                                            required>
                                            <option value="">Sila Pilih</option>
                                            @foreach ($jabatan as $jaw)
                                                <option value="{{ $jaw->jabatan_id }}"
                                                    {{ $jaw->jabatan_id == $users->jabatan ? 'selected' : '' }}>
                                                    {{ $jaw->nama_jabatan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Taraf</label>
                                        <select name="taraf" id="taraf" class="form-control {{ $errors->has('taraf') ? ' is-invalid' : '' }} select2bs4" required>
                                            <option value="">Pilih Taraf</option>
                                            <option value="Tetap" {{ $users->taraf == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                                            <option value="Jawatan Berasaskan Caruman (JBC)" {{ $users->taraf == 'Jawatan Berasaskan Caruman (JBC)' ? 'selected' : '' }}>Jawatan Berasaskan Caruman (JBC)</option>
                                            <option value="Sementara" {{ $users->taraf == 'Sementara' ? 'selected' : '' }}>Sementara</option>
                                            <option value="Contract Of Service (COS)" {{ $users->taraf == 'Contract Of Service (COS)' ? 'selected' : '' }}>Contract Of Service (COS)</option>
                                            <option value="Contract For Service (CFS)" {{ $users->taraf == 'Contract For Service (CFS)' ? 'selected' : '' }}>Contract For Service (CFS)</option>
                                            <option value="Berelaun" {{ $users->taraf == 'Berelaun' ? 'selected' : '' }}>Berelaun</option>
                                            <option value="Sambilan" {{ $users->taraf == 'Sambilan' ? 'selected' : '' }}>Sambilan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Jawatan</label>
                                        <select class="form-control select2bs4" name="jawatan" style="width: 100%;"
                                            required>
                                            <option value="">Sila Pilih</option>
                                            @foreach ($jawatan as $jaw)
                                                <option value="{{ $jaw->idJawatan }}"
                                                    {{ $jaw->idJawatan == $users->jawatan ? 'selected' : '' }}>
                                                    {{ $jaw->namaJawatan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Kod Gred</label>
                                        <select class="form-control select2bs4" name="kod" style="width: 100%;" required>
                                            <option value="">Sila Pilih</option>
                                            @foreach ($kod as $jaw)
                                                <option value="{{ $jaw->gred_kod_ID }}"
                                                    {{ $jaw->gred_kod_ID == $users->gredKod ? 'selected' : '' }}>
                                                    {{ $jaw->gred_kod_abjad }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Gred</label>
                                        <select class="form-control select2bs4" name="gred" style="width: 100%;" required>
                                            <option value="">Sila Pilih</option>
                                            @foreach ($angka as $jaw)
                                                <option value="{{ $jaw->gred_angka_ID }}"
                                                    {{ $jaw->gred_angka_ID == $users->gredAngka ? 'selected' : '' }}>
                                                    {{ $jaw->gred_angka_nombor }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <div class="">
                                @if (url()->current() == route('kemaskini-pengguna', [$users->usersID]))
                                <a href="{{ url('senaraiPengguna') }}" class="btn btn-danger">Kembali</a>
                                @elseif (url()->current() == route('kemaskini-pentadbir', [$users->usersID]))
                                <a href="{{ url('senaraiPic') }}" class="btn btn-danger">Kembali</a>
                                @endif

                                <a href="{{ url('reset-kata-laluan', [$users->usersID]) }}" class="btn btn-info">Set
                                    Semula Kata Luluan</a>
                                {!! Form::submit('Kemaskini', ['class' => 'btn btn-success']) !!}
                            </div>
                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection

@section('script')
@endsection
