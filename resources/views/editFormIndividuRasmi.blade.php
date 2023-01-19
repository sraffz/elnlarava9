@extends('layouts.eln')

@section('title', 'Kemaskini')

@section('link')
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet"
        href="{{ asset('adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/bower_components/select2/dist/css/select2.min.css') }}">

@endsection

@section('content')


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="box-title">Kemaskini Permohonan</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{ url('senaraiPermohonanProses', [Auth::user()->usersID]) }}">Senarai
                                Permohonan</a></li>
                        <li class="breadcrumb-item active">Kemaskini Permohonan</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    {!! Form::model($permohonan, ['method' => 'POST', 'url' => ['updatePermohonan', $permohonan->permohonansID], 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
    {!! Form::hidden('id', $permohonan->permohonansID) !!}
    <section class="content">
        <div class="container-fluid">
            @include('flash::message')
            <!-- general form elements disabled -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Maklumat Permohonan Perjalanan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><i class="fa fa-calendar"></i> Tarikh Terima Insuran</label>
                                <div class="input-group date">
                                    @php
                                        $da = date('m/d/Y', strtotime($permohonan->tarikhInsuran));
                                    @endphp
                                    <input type="text" pattern="\d{2}-\d{2}-\d{4}" class="form-control datepicker"
                                        name="tarikh" value="{{ \Carbon\Carbon::parse($permohonan->tarikhInsuran)->format('d-m-Y') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><i class="fa fa-calendar"></i> Tarikh Mula Perjalanan</label>
                                <div class="input-group date">
                                    @php
                                        $mula = date('m/d/Y', strtotime($permohonan->tarikhMulaPerjalanan));
                                    @endphp
                                    <input type="text" pattern="\d{2}-\d{2}-\d{4}" class="form-control datepicker"
                                        name="tarikhMulaPerjalanan" value="{{ \Carbon\Carbon::parse($permohonan->tarikhMulaPerjalanan)->format('d-m-Y') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><i class="fa fa-calendar"></i> Tarikh Akhir Perjalanan</label>
                                <div class="input-group date">
                                    @php
                                        $akhir = date('m/d/Y', strtotime($permohonan->tarikhAkhirPerjalanan));
                                    @endphp
                                    <input type="text" pattern="\d{2}-\d{2}-\d{4}" class="form-control datepicker"
                                        name="tarikhAkhirPerjalanan" value="{{ \Carbon\Carbon::parse($permohonan->tarikhAkhirPerjalanan)->format('d-m-Y') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><i class="fa fa-globe"></i> Negara</label>
                                <div class="input-group">
                                    <select style="width: 100%;" id="negara" class="form-control select2bs4" name="negara">
                                        <option value="" selected="selected"></option>
                                        @foreach ($negara as $jaw)
                                            <option value="{{ $jaw->namaNegara }}"
                                                {{ $permohonan->negara == $jaw->namaNegara ? 'selected' : '' }}>
                                                {{ $jaw->namaNegara }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            @if ($typeForm == 'rasmi')
                                <div class="form-group">
                                    <label><i class="fa fa-edit"></i> Tujuan Permohonan</label>
                                    <div class="input-group">
                                        <input type="text" name="tujuan" class="form-control"
                                            value="{{ $permohonan->lainTujuan }}">
                                    </div>
                                </div>
                            @elseif($typeForm == 'tidakRasmi')
                                <div class="form-group">
                                    <label><i class="fa fa-edit"></i> Tujuan Permohonan</label>
                                    <div class="input-group">
                                        <input type="text" id="tujuan" name="tujuan" class="form-control"
                                            value="{{ $permohonan->lainTujuan }}">
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><i class="fa fa-edit"></i> Alamat Semasa Bercuti</label>
                                <div class="input-group">
                                    <input type="text" name="alamat" class="form-control"
                                        value="{{ $permohonan->alamat }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label><i class="fa fa-phone"></i> No. Telefon</label>
                            <div class="input-group">
                                <input type="text" name="phone" class="form-control"
                                    value="{{ $permohonan->telefonPemohon }}">
                            </div>
                        </div>
                        @if ($typeForm == 'rasmi')
                            <div class="col-md-4">
                                <label><i class="fa fa-calendar"></i> Jenis Kewangan</label>
                                <div class="input-group">
                                    {!! Form::select('jenisKewangan', ['' => 'Sila pilih', 'Kerajaan' => 'Kerajaan', 'Federal' => 'Federal', 'Persendirian' => 'Persendirian', 'Jabatan' => 'Jabatan', 'Syarikat' => 'Syarikat', 'lain-lain' => 'lain-lain'], $permohonan->jenisKewangan, ['class' => 'form-control', 'required']) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label><i class="fa fa-file"></i> Dokumen Rasmi </label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="fileRasmi[]"
                                            id="exampleInputFile" multiple>
                                        <label class="custom-file-label" for="exampleInputFile">Pilih Fail</label>
                                    </div>
                                </div>
                                @if ($dokumen->isEmpty())
                                    <label for="nama" class="label-danger">Tiada Dokumen</label>
                                @else
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($dokumen as $doku)
                                        <div class="mt-2">
                                            <a class="btn btn-sm btn-info"
                                                href="{{ route('detailPermohonanDokumen.download', ['id' => $doku->dokumens_id]) }}">

                                                <i class="fa fa-download"></i> Dokumen Rasmi {{ $i++ }}
                                            </a>
                                            <a
                                                href="{{ route('detailPermohonan.deleteFileRasmi', ['id' => $doku->dokumens_id]) }}">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @elseif($typeForm == 'tidakRasmi')
                            <input type="hidden" name="jenisKewangan" value="Persendirian">
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-4 mt-4">
                            <label><i class="fa fa-file"></i> Dokumen Sokongan </label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="filesokongan[]"
                                        id="exampleInputFile" multiple>
                                    <label class="custom-file-label" for="exampleInputFile">Pilih Fail</label>
                                </div>
                            </div>
                            @if ($dokumen_sokongan->isEmpty())
                                <label for="nama" class="label-danger">Tiada Dokumen</label>
                            @else
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($dokumen_sokongan as $doku)
                                    <div class="mt-2">
                                        <a class="btn btn-sm btn-info"
                                            href="{{ route('detailPermohonanDokumensokongan.download', ['id' => $doku->dokumens_id_sokongan]) }}">

                                            <i class="fa fa-download"></i> Dokumen Sokongan {{ $i++ }}
                                        </a>
                                        <a
                                            href="{{ route('detailPermohonan.deleteFileSokongan', ['id' => $doku->dokumens_id_sokongan]) }}">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mt-4">
                            <div class="form-group">
                                <label for="catatan_permohonan">Catatan</label>
                                <textarea class="form-control" name="catatan_permohonan" id="catatan_permohonan"
                                    rows="3">{{ $permohonan->catatan_permohonan }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Maklumat Pasangan / Keluarga / Saudara Pegawai Keluar Negara</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><i class="fa fa-user"></i> Nama Pasangan</label>
                                <div class="input-group">
                                    <input type="text" name="namaPasangan" class="form-control"
                                        value="{{ $permohonan->pasanganPermohonan->namaPasangan }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><i class="fa fa-phone"></i> No. Telefon Pasangan</label>
                                <div class="input-group">
                                    <input type="text" name="phonePasangan" class="form-control"
                                        value="{{ $permohonan->pasanganPermohonan->phonePasangan }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><i class="fa fa-envelope"></i> E-mel Pasangan</label>
                                <div class="input-group">
                                    <input type="email" name="emailPasangan" class="form-control"
                                        value="{{ $permohonan->pasanganPermohonan->emailPasangan }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><i class="fa fa-user-friends"></i> Hubungan</label>
                                <div class="input-group">
                                    <input type="text" name="hubungan" class="form-control"
                                        value="{{ $permohonan->pasanganPermohonan->hubungan }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label><i class="fa fa-edit"></i> Alamat Pasangan</label>
                            <div class="input-group">
                                <textarea class="form-control" name="alamatPasangan" id="alamatPasangan"
                                    cols="170">{{ $permohonan->pasanganPermohonan->alamatPasangan }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($typeForm == 'tidakRasmi')
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Maklumat Pasangan / Keluarga / Saudara Pegawai Keluar negara</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><i class="fa fa-calendar"></i> Tarikh Mula Cuti</label>
                                    <div class="input-group date">
                                        <input type="text" pattern="\d{2}-\d{2}-\d{4}" class="form-control datepicker"
                                             name="tarikhMulaCuti"
                                            value="{{ \Carbon\Carbon::parse($permohonan->tarikhMulaCuti)->format('d-m-Y') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><i class="fa fa-calendar"></i> Tarikh Akhir Cuti</label>
                                    <div class="input-group date">
                                       
                                        <input type="text" pattern="\d{2}-\d{2}-\d{4}" class="form-control datepicker"
                                             name="tarikhAkhirCuti"
                                            value="{{ \Carbon\Carbon::parse($permohonan->tarikhAkhirCuti)->format('d-m-Y') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><i class="fa fa-calendar"></i> Tarikh Kembali Bertugas</label>
                                    <div class="input-group date">
                                      
                                        <input type="text" pattern="\d{2}-\d{2}-\d{4}" class="form-control datepicker"
                                            name="tarikhKembaliBertugas"
                                            value="{{ \Carbon\Carbon::parse($permohonan->tarikhKembaliBertugas)->format('d-m-Y') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label>Dokumen Cuti</label>
                                {{-- <div class="input-group">
                                    <input type="file" class="form-control" name="fileCuti[]" multiple />
                                </div> --}}
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="fileCuti[]" id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">Pilih Fail</label>
                                </div>
                                @if (is_null($permohonan->namaFileCuti))
                                    <label class="label label-warning">Tiada Dokumen</label>
                                @else
                                    <div class="mt-2">
                                        <a class="btn btn-sm btn-info"
                                            href="{{ route('detailPermohonan.download', ['id' => $permohonan->permohonansID]) }}">
                                            <i class="fa fa-download"></i> Dokumen Cuti
                                        </a>
                                        <a
                                            href="{{ route('detailPermohonan.deleteFileCuti', ['id' => $permohonan->permohonansID]) }}">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="text-center">
                @if ($typeForm == 'rasmi')
                    <input type="hidden" name="jenisPermohonan" value="Rasmi">
                @elseif($typeForm == 'tidakRasmi')
                    <input type="hidden" name="jenisPermohonan" value="Tidak Rasmi">
                @endif
                <input type="hidden" name="pasanganID" value="{{ $permohonan->pasanganPermohonan->pasangansID }}">
                <div class="">
                    {{-- {!! Form::reset("Semula", ['class' => 'btn btn-warning']) !!} --}}
                    <a href="{{ url('senaraiPermohonanProses') }}" class="btn btn-danger">Kembali</a>
                    {!! Form::submit('Kemaskini', ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
    </section>
@endsection

@section('script')
    <!-- Select2 -->
    <script src="{{ asset('adminlte/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('adminlte/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- bootstrap datepicker -->
    <script src="{{ asset('adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}">
    </script>

    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()
            //Date range picker
            $('#reservation').daterangepicker()
            $('#reservation2').daterangepicker()
            //Date range as a button
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                            'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function(start, end) {
                    $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                        'MMMM D, YYYY'))
                }
            )
            //Date picker
            $('.datepicker').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy',
                orientation: "bottom",
            })
        })
    </script>

@endsection
