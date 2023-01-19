@extends('layouts.starter')

@section('title', 'Carian PDF')

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
      
      {!! Form::open(['method' => 'POST', 'url' => '/printpdf', 'class' => 'form-horizontal']) !!}
         

                <label>Tempat</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <select class="form-control select2" id="tempat" name="tempat">
						<option value="">Pilih</option>
                  		@foreach ($negara as $nega)
                  			<option value="{{$nega->namaNegara}}">{{$nega->namaNegara}}</option>
                  		@endforeach
				    </select>
                </div>
				<br>

                <label>Status Lulus/Tolak</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <select class="form-control" id="status" name="status">
                  		<option value="">Pilih</option>
				        <option value="Permohonan Berjaya">Lulus</option>
				        <option value="Permohonan Gagal">Tolak</option>
				    </select>
                </div>
                <br>

                {{-- <label>Mencukupi Tempoh 15 hari</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <select class="form-control" id="tempoh" name="tempoh">
                  		<option value="">Pilih</option>
      				        <option value="Ya">Ya</option>
      				        <option value="Tidak">Tidak</option>
      				    </select>
                </div>
			          <br> --}}

			         <label>Sumber Kewangan</label>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <select class="form-control" id="jenisKewanganRom" name="jenisKewanganRom" >
      				        <option value="">Pilih</option>
      				        <option value="Kerajaan Negeri">Kerajaan Negeri</option>
      				        <option value="Kerajaan Persekutuan">Kerajaan Persekutuan</option>
      				        <option value="Persendirian">Persendirian</option>
      				        <option value="Jabatan">Jabatan</option>
      				        <option value="Syarikat">Syarikat</option>
      				        <option value="lain-lain">lain-lain</option>
      				    </select>
                </div>
      			       <br>

                  

			     <div class="btn-group pull-left">
			        {{-- {!! Form::reset("Semula", ['class' => 'btn btn-warning']) !!}
              {!! Form::submit("View", ['class' => 'btn btn-info']) !!}
			        {!! Form::submit("PDF", ['class' => 'btn btn-success']) !!} --}}
              <input id='Semula' type='reset' name = 'Semula' value = 'Semula' class="btn btn-warning">
              <input id='pdf' type='submit' name = 'pdf' value = 'view' class="btn btn-info">
              <input id='pdf' type='submit' name = 'pdf' value = 'pdf' class="btn btn-success">
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
<script src="{{ asset('adminlte/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<!-- date-range-picker -->
<script src="{{ asset('adminlte/bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{ asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap datepicker -->
<script src="{{ asset('adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
    //Date range picker
    $('#reservation').daterangepicker()
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })
    //Date picker
    $('#datepicker1').datepicker({
      autoclose: true
    })
  })
</script>

@endsection
