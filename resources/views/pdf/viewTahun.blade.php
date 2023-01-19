@extends('layouts.starter')

@section('title', 'Laporan Individu')

@section('link')
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="{{ asset('adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('adminlte/bower_components/select2/dist/css/select2.min.css')}}">
  

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
            <div class="box-header with-border">
              <h3 class="box-title">Carian</h3>
            </div>
                    <div class="box-body">

          <form action="{{route('proViewTahun')}}" method="post"> 
            {{ csrf_field() }}
             

              <label> Laporan Tahun</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <select class="form-control" id="tahun" name="tahun">
                      <option value="">Pilih</option>
                      <option value="2018">2018</option>
                      <option value="2019">2019</option>
                      <option value="2020">2020</option>
                      <option value="2021">2021</option>
                  </select>
                </div>

                <hr>
                  
                <div class="col-12">
                <a href="javascript:history.go(-1)" class="btn btn-sm btn-warning">Kembali</a>
                  <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Adakah Pasti?')">Print</button>
                  
           </div>
        </div>
    </div>
    {{-- <div class="col-md-2">
    </div> --}}
</div>
@endsection

@section('script')
<!-- Select2 -->
<script src="{{ asset('adminlte/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<!-- date-range-picker -->
<script src="{{ asset('adminlte/bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{ asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap datepicker -->
<script src="{{ asset('adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>

@endsection
