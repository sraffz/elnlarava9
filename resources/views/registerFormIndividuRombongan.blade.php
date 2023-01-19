@extends('layouts.eln')

@section('title', 'Permohonan Bagi Rombongan')

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
    <section class="content-header">
        <div class="container-fluid">
            @include('flash::message')
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="box-title">Borang Pemohonan Sertai Rombongan</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Halaman Utama</a></li>
                        <li class="breadcrumb-item active">Permohonan Rombongan</li>
                    </ol>
                </div>
            </div>
          
        </div><!-- /.container-fluid -->
    </section>

    {!! Form::model($userDetail, [
        'method' => 'POST',
        'url' => ['sertai-rombongan', $userDetail->usersID],
        'class' => 'form-horizontal',
        'autocomplete' => 'off',
        'enctype' => 'multipart/form-data',
    ]) !!}
    {!! Form::hidden('id', $userDetail->usersID) !!}
    <section class="content">
        <div class="container-fluid">
            @include('flash::message')
            <!-- general form elements disabled -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Maklumat Rombongan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="{{ $errors->has('kodRombo') ? ' has-error' : '' }}">
                                {!! Form::label('kodRombo', 'Kod Rombongan**') !!}
                                {!! Form::text('kodRombo', old('kodRombo'), ['class' => 'form-control', 'required' => 'required']) !!}
                                <small class="text-danger">{{ $errors->first('kodRombo') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mt-3">
                            <label><i class="fa fa-file"> </i> Dokumen Sokongan</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="filesokonganSertaiRom[]" id="exampleInputFile"
                                    multiple>
                                <label class="custom-file-label" for="exampleInputFile">Pilih Fail</label>
                                <small><i>*tertakluk kepada kelulusan dalaman bagi pejabat daerah atau perkara
                                        berkaitan.</i></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Maklumat kelulusan cuti rehat(Sekiranya memerlukan kelulusan cuti rehat)</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <!-- text input -->
                            <div class="form-group">
                                <label><i class="fas fa-calendar"></i> Tarikh Mula Cuti</label>
                                <input type="text"
                                    class="form-control datepicker {{ $errors->has('tarikhMulaCuti') ? 'is-invalid' : '' }}"
                                    name="tarikhMulaCuti" value="{{ old('tarikhMulaCuti') }}">
                                @if ($errors->has('tarikhMulaCuti'))
                                    <span class="error invalid-feedback">Tarikh diperlukan</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <!-- text input -->
                            <div class="form-group">
                                <label><i class="fas fa-calendar"></i> Tarikh Akhir Cuti</label>
                                <input type="text"
                                    class="form-control datepicker {{ $errors->has('tarikhAkhirCuti') ? 'is-invalid' : '' }}"
                                    name="tarikhAkhirCuti" value="{{ old('tarikhAkhirCuti') }}">
                                @if ($errors->has('tarikhAkhirCuti'))
                                    <span class="error invalid-feedback">Tarikh diperlukan</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <!-- text input -->
                            <div class="form-group">
                                <label><i class="fas fa-calendar"></i> Tarikh Kembali Bertugas</label>
                                <input type="text"
                                    class="form-control datepicker {{ $errors->has('tarikhKembaliBertugas') ? 'is-invalid' : '' }}"
                                    name="tarikhKembaliBertugas" value="{{ old('tarikhKembaliBertugas') }}">
                                @if ($errors->has('tarikhKembaliBertugas'))
                                    <span class="error invalid-feedback">Tarikh kembali bertugas diperlukan</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <!-- text input -->
                            <div class="form-group">
                                <label><i class="fa fa-file"> </i> Dokumen Cuti</label>
                                <div class="custom-file">
                                    <input type="file"
                                        class="custom-file-input {{ $errors->has('fileCuti') ? 'is-invalid' : '' }}"
                                        name="fileCuti[]" id="exampleInputFile" multiple>
                                    <label class="custom-file-label" for="exampleInputFile">Pilih Fail</label>
                                    @if ($errors->has('fileCuti'))
                                        <span class="error invalid-feedback">Dokumen perlu dimuat naik</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="catatan_permohonan">Catatan</label>
                                <textarea class="form-control" name="catatan_permohonan" id="catatan_permohonan" rows="3">{{ old('catatan_permohonan') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Perakuan Permohonan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- checkbox -->
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tick" id="tick"
                                        value="yes" required>
                                    <label class="form-check-label">Saya dengan
                                        ini mematuhi segala peraturan yang telah ditetapkan di perenggan 6(i),(ii) dan
                                        perenggan
                                        10 Surat Pekeliling Bilangan 3 Tahun 2012.</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            {!! Form::reset('Semula', ['class' => 'btn btn-danger']) !!}
                            {!! Form::submit('Hantar', ['class' => 'btn btn-success']) !!}
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>

        </div>
    </section>
    {!! Form::close() !!}
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
                format: 'd-m-yyyy'
            })
        })
    </script>

@endsection
