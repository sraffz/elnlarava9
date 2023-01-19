@extends('layouts.eln')

@section('title', 'Tambah Gred Kod')

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
    @include('flash::message')
    <div class="row">
        <!-- left column -->
        {{-- <div class="col-md-2">
        </div> --}}
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-body">
                    <h3>Tambah Gred Kod</h3>
                    {!! Form::open(['method' => 'POST', 'url' => 'prosesTambahGredKod']) !!}
                    {{ csrf_field() }}
                    <label>Gred Kod</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control" id="kod" name="kod" required placeholder="F">
                    </div>
                    <label>Gred Kod Klasifikasi</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control" id="klasifikasi" name="klasifikasi" required
                            placeholder="Teknologi Maklumat">
                    </div>
                    <div class="btn-group pull-right">
                        <a href="javascript:history.back()" class="btn btn-warning">Kembali</a>

                        {!! Form::submit('Daftar', ['class' => 'btn btn-success']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>


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

@endsection
