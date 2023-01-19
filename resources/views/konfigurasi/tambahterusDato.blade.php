@extends('layouts.eln')

@section('title', 'Tambah Jawatan')

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
                    <h3>Tambah Jawatan</h3>
                    <br>
                    {!! Form::open(['method' => 'POST', 'url' => 'prosesTambahterusDato']) !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="POST">


                    <label>Nama Jawatan</label>
                    <div class="input-group">
                        <select style="width: 100%;" id="jawatan" class="form-control select2" name="jawatan"
                            required="required">
                            <option value="" selected="selected"></option>
                            @foreach ($jawatan as $jaw)
                                <option value="{{ $jaw->idJawatan }}">{{ $jaw->namaJawatan }}</option>
                            @endforeach
                        </select>{{-- {{$k->anugerah}} --}}
                    </div>
                    <br>

                    <div class="btn-group pull-right">
                        <a href="javascript:history.back()" class="btn btn-warning">Kembali</a>

                        {!! Form::submit('Daftar', ['class' => 'btn btn-success']) !!}
                    </div>

                    {!! Form::close() !!}


                </div>
            </div>
        </div>
        {{-- <div class="col-md-2">
    </div> --}}
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
