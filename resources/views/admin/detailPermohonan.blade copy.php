@extends('layouts.eln')

@section('title', 'E-Luar Negara')

@section('link')

@endsection

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Butiran Permohonan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{ url('senaraiPermohonanProses', [Auth::user()->usersID]) }}">Senarai
                                Permohonan</a></li>
                        <li class="breadcrumb-item active">Butiran Permohonan</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Maklumat Pemohon</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input type="text" class="form-control" disabled value="{{ $permohonan->user->nama }}">
                            </div>
                            <div class="form-group">
                                <label for="">Kad Pengenalan</label>
                                <input type="text" class="form-control" disabled value="{{ $permohonan->user->nokp }}">
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="text" class="form-control" disabled value="{{ $permohonan->user->email }}">
                            </div>
                            <div class="form-group">
                                <label for="">Jawatan & Gred</label>
                                <textarea style="resize: none" class="form-control" cols="30" rows="2"
                                    disabled>{{ $permohonan->user->userJawatan->namaJawatan }}({{ $permohonan->user->userGredKod->gred_kod_abjad }}{{ $permohonan->user->userGredAngka->gred_angka_nombor }})</textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Jabatan</label>
                                <textarea style="resize: none" class="form-control" cols="30" rows="2"
                                    disabled>{{ $permohonan->user->userJabatan->nama_jabatan }} ({{ $permohonan->user->userJabatan->kod_jabatan }})</textarea>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Maklumat Permohonan</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Negara</label>
                                        <input type="text" class="form-control" disabled
                                            value="{{ $permohonan->negara }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <textarea style="resize: none" class="form-control" disabled
                                            rows="3">{{ $permohonan->alamat }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Jenis Permohonan</label>
                                        <input type="text" class="form-control" disabled
                                            value=" {{ $permohonan->JenisPermohonan }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Tujuan</label>
                                        <input type="text" class="form-control" disabled
                                            value=" {{ $permohonan->lainTujuan }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mula">Mula Perjalanan</label>
                                        <input id="mula" type="text" class="form-control"
                                            value="{{ \Carbon\Carbon::parse($permohonan->tarikhMulaPerjalanan)->format('d/m/Y') }}"
                                            disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="akhir">Tamat Perjalanan</label>
                                        <input id="akhir" type="text" class="form-control"
                                            value="{{ \Carbon\Carbon::parse($permohonan->tarikhAkhirPerjalanan)->format('d/m/Y') }}"
                                            disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="jumlah">Jumlah</label>
                                        <input id="jumlah" type="text" class="form-control"
                                            value="{{ $jumlahDate }} Hari" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="catatan">Catatan</label>
                                        <textarea style="resize: none" class="form-control" disabled
                                            disabled>{{ $permohonan->catatan_permohonan }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>

            @php
                $jumlah = 0;
            @endphp

            @foreach ($pasangan as $ppp)
                @php
                    $jumlah++;
                @endphp
                {{-- {{ $jumlah }} --}}
                @if ($ppp->namaPasangan != null || $ppp->namaPasangan != '')
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Maklumat Pasangan/Keluarga/Saudara Pegawai Di Luar Negara</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label><i class="fa fa-user"></i> Nama Pasangan</label>
                                        <input type="text" name="namaPasangan" class="form-control"
                                            value="{{ $ppp->namaPasangan }}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label><i class="fa fa-user-friends"></i> Hubungan</label>
                                        <input type="text" name="hubungan" class="form-control"
                                            value="{{ $ppp->hubungan }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label><i class="fa fa-phone"></i> No Tel Pasangan</label>
                                        <input type="text" name="phonePasangan" class="form-control"
                                            data-inputmask='"mask": "(99) 99-99999999"' data-mask
                                            value="{{ $ppp->phonePasangan }}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label><i class="fa fa-envelope"></i> Email Pasangan (Jika Ada)</label>
                                        <input type="email" name="emailPasangan" class="form-control"
                                            value="{{ $ppp->emailPasangan }}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- textarea -->
                                    <div class="form-group">
                                        <label><i class="fa fa-edit"></i> Alamat Pasangan</label>
                                        <textarea class="form-control" name="alamatPasangan" rows="3" value=""
                                            disabled>{{ $ppp->alamatPasangan }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- /.card-body -->
                    </div>
                @endif
            @endforeach

            @php
                $type = $permohonan->JenisPermohonan;
            @endphp
            @if ($type == 'Tidak Rasmi' || $type == 'rombongan')
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Maklumat Cuti</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="mula">Mula</label>
                                            <input id="mula" type="text" class="form-control"
                                                value="{{ \Carbon\Carbon::parse($permohonan->tarikhMulaCuti)->format('d/m/Y') }}"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="akhir">Akhir</label>
                                            <input id="akhir" type="text" class="form-control"
                                                value="{{ \Carbon\Carbon::parse($permohonan->tarikhAkhirCuti)->format('d/m/Y') }}"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="jumlah">Kembali bertugas</label>
                                            <input id="jumlah" type="text" class="form-control"
                                                value="{{ \Carbon\Carbon::parse($permohonan->tarikhKembaliBertugas)->format('d/m/Y') }}"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="jumlah">Jumlah Cuti</label>
                                            <input id="jumlah" type="text" class="form-control"
                                                value="{{ $jumlahDateCuti }} Hari" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Dokumen</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @php
                                $type = $permohonan->JenisPermohonan;
                            @endphp

                            @if ($type == 'Rasmi')
                                <strong><i class="fa fa-book margin-r-5"></i>Dokumen Rasmi</strong>
                                <p class="text-muted">
                                    @if ($dokumen->isEmpty())
                                        Tiada Dokumen
                                    @else
                                        @foreach ($dokumen as $doku)
                                            <a class="btn btn-sm btn-info"
                                                href="{{ route('detailPermohonanDokumen.download', ['id' => $doku->dokumens_id]) }}">{{ $doku->namaFile }}</a>
                                        @endforeach
                                    @endif
                                </p>
                            @elseif ($type == 'Tidak Rasmi' || $type == 'rombongan')
                                <strong><i class="fa fa-book margin-r-5"></i>Dokumen Cuti</strong>
                                <p class="text-muted">
                                    @if ($permohonan->namaFileCuti == '')
                                        Tiada Dokumen
                                    @else
                                        <a class="btn btn-sm btn-info"
                                            href="{{ route('detailPermohonan.download', ['id' => $permohonan->permohonansID]) }}">{{ $permohonan->namaFileCuti }}</a>
                                    @endif
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <a href="{{ URL::previous() }}" class="btn btn-primary">Kembali</a>
                </div>
            </div>
            <br>
        </div>
    </section>
@endsection
