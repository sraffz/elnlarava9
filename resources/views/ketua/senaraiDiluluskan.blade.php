@extends('layouts.eln')

@section('title','Senarai Permohonan')

@section('link')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('adminlte-3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
@include('flash::message')
 <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Senarai Permohonan individu</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-wrench"></i></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
              <table class="table table-bordered table-striped display">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Negara</th>
                  <th>Jenis/Tujuan</th>
                  <th>Tarikh Mula Perjalanan</th>
                  <th>Tarikh Akhir Perjalanan</th>
                  <th>Status Permohonan</th>
                  <th>Tarikh Keputusan</th>
                  <th>Tindakan</th>
                </tr>
                </thead>
                @php
                  $no=1;
                @endphp
                <tbody>
               @foreach($allPermohonan as $mohonan)
                <tr>
                  <td>@php
                    echo $no;
                    $no=$no+1;
                  @endphp</td>
                  <td><a href="/detailPermohonan/{{ $mohonan->permohonansID }}">{{ $mohonan->negara }}</a></td>
                  <td>{{ $mohonan->JenisPermohonan }}({{ $mohonan->lainTujuan }})</td>
                  <td>{{\Carbon\Carbon::parse($mohonan->tarikhMulaPerjalanan)->format('d/m/Y')}}</td>
                  <td>{{\Carbon\Carbon::parse($mohonan->tarikhAkhirPerjalanan)->format('d/m/Y')}}</td>
                  <td>@if ($mohonan->statusPermohonan == "Permohonan Berjaya")
                        <span class="label label-success">Berjaya</span>
                     @elseif($mohonan->statusPermohonan == "Permohonan Gagal")
                        <span class="label label-danger">Gagal</span>
                    @else
                        <span class="label label-primary">Tiada</span>
                    @endif</td>
                  <td>
                    <h4><span class="label label-primary">{{\Carbon\Carbon::parse($mohonan->tarikhLulusan)->format('d/m/Y')}}</span>
                    </td>
                  <td>

                    <a href="#{{-- /senaraiPermohonan/{{$rombo->rombongans_id}}/tamat --}}" class="btn btn-warning btn-xs" onclick="javascript: return confirm('Padam maklumat ini?');"><i class="fa fa-print"></i></a>
                  </td>
                  
               @endforeach
            
                </tbody>
              </table>
                  <!-- /.chart-responsive -->
                </div>
                <!-- /.col -->
                
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
            
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
 </div>

{{-- ------------------------------------------------------------------------------------------------- --}}
  

  <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Senarai Rombongan</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-wrench"></i></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <table id="tableBaru" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Negara</th>
                  <th>Code</th>
                  <th>Tujuan Rombongan</th>
                  <th>Tarikh Mula Perjalanan</th>
                  <th>Tarikh Akhir Perjalanan</th>
                  <th>Peserta</th>
                  <th>Status Permohonan</th>
                  {{-- <th>Tarikh Lulusan Permohonan</th> --}}
                  <th>Tindakan</th>
                </tr>
                </thead>

                @php
                  $no=1;
                @endphp
                
                <tbody>
               @foreach($rombongan as $rombo)
                <tr>
                  <td>
                    @php
                    echo $no;
                    $no=$no+1;
                  @endphp
                  </td>
                  <td><a href="/detailPermohonanRombongan/{{ $rombo->rombongans_id }}">{{ $rombo->negaraRom }}</a></td>
                  <td>{{ $rombo->codeRom }}</td>
                  <td>{{ $rombo->tujuanRom }}</td>
                  <td>{{\Carbon\Carbon::parse($rombo->tarikhMulaRom)->format('d/m/Y')}}</td>
                  <td>{{\Carbon\Carbon::parse($rombo->tarikhAkhirRom)->format('d/m/Y')}}</td>
                  <td>@foreach ($allPermohonan as $element)
                    @if ($element->rombongans_id == $rombo->rombongans_id)
                        @if ($element->statusPermohonan == "Permohonan Berjaya")
                        <span class="label label-success">{{ $element->user->nama }}</span><br>
                         @elseif($element->statusPermohonan == "Permohonan Gagal")
                            <span class="label label-danger">{{ $element->user->nama }}</span><br>
                        @else
                            <span class="label label-primary">Tiada</span>
                        @endif
                      
                    @endif
                  @endforeach</td>
                  <td>@if ($rombo->statusPermohonanRom == "Permohonan Berjaya")
                        <span class="label label-success">Berjaya</span>
                     @elseif($rombo->statusPermohonanRom == "Permohonan Gagal")
                        <span class="label label-danger">Gagal</span>
                    @else
                        <span class="label label-primary">Tiada</span>
                    @endif</td>
                  {{-- <td>{{\Carbon\Carbon::parse($rombo->tarikhLulusan)->format('d/m/Y')}}</td> --}}
                  
                  <td>
                   <a href="#{{-- /senaraiPermohonan/{{$rombo->rombongans_id}}/tamat --}}" class="btn btn-warning btn-xs" onclick="javascript: return confirm('Padam maklumat ini?');"><i class="fa fa-print"></i></a>
                  </td>
                  
                  
               @endforeach
            
                </tbody>
                
              </table>
                 
                </div>
                <!-- /.col -->
                
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
            
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
 </div>


            
@endsection

@section('script')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('adminlte-3/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte-3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte-3/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte-3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte-3/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('adminlte-3/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte-3/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('adminlte-3/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('adminlte-3/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('adminlte-3/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('adminlte-3/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('adminlte-3/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('table.display').DataTable({
                "pageLength": 5,
                "lengthMenu": [5, 10, 15, 20],
                "language": {
                    "emptyTable": "Tiada data",
                    "lengthMenu": "_MENU_ Rekod setiap halaman",
                    "zeroRecords": "Tiada padanan rekod yang dijumpai.",
                    "info": "Paparan dari _START_ hingga _END_ dari _TOTAL_ rekod",
                    "infoEmpty": "Paparan 0 hingga 0 dari 0 rekod",
                    "infoFiltered": "(Ditapis dari jumlah _MAX_ rekod)",
                    "search": "Carian:",
                    "oPaginate": {
                        "sFirst": "Pertama",
                        "sPrevious": "Sebelum",
                        "sNext": "Seterusnya",
                        "sLast": "Akhir"
                    }
                },
            });
        });

        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection




