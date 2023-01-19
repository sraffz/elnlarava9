@extends('layouts.eln')

@section('title', 'Senarai Pic Jabatan')

@section('link')

@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12"> <br>
                @include('flash::message')
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            Tambah Pentadbir
                        </div>
                        <div class="card-body">
                            {!! Form::open(['method' => 'POST', 'url' => 'daftarJabatan', 'autocomplete' => 'off']) !!}
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label>Nama</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>No KP (Username)</label>
                                        <div class="input-group">
                                            <input maxlength="12" data-inputmask='"mask": "999999999999"' data-mask type="text"
                                                class="form-control" id="nokp" name="nokp" placeholder="999999999999" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <div class="input-group">
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Peranan</label>
                                        <div class="input-group">
                                            <select style="width: 100%;" id="role" class="form-control select2bs4" name="role"
                                                required=>
                                                <option value="">Sila Pilih</option>
                                                <option value="jabatan">Ketua Jabatan</option>
                                                <option value="adminBPSM">Admin PSM</option>
                                                <option value="DatoSUK">Admin Pejabat Dato</option>
                                                <option value="pengguna">Pengguna</option>
                                            </select>{{-- {{$k->anugerah}} --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jabatan</label>
                                        <div class="input-group">
                                            <select style="width: 100%;" id="jabatan" class="form-control select2bs4" name="jabatan"
                                                required>
                                                <option value="">Sila Pilih</option>
                                                @foreach ($jabatan as $jab)
                                                    <option value="{{ $jab->jabatan_id }}">{{ $jab->nama_jabatan }}</option>
                                                @endforeach
                                            </select>{{-- {{$k->anugerah}} --}}
                                        </div>
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
                                                <option value="{{ $jaw->idJawatan }}">
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
                                                <option value="{{ $jaw->gred_kod_ID }}">
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
                                                <option value="{{ $jaw->gred_angka_ID }}">
                                                    {{ $jaw->gred_angka_nombor }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <div class="pull-right">
                                {!! Form::reset('Set Semula', ['class' => 'btn btn-warning']) !!}
                                {!! Form::submit('Daftar', ['class' => 'btn btn-success']) !!}
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
