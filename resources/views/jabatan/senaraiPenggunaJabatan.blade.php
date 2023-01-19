@extends('layouts.eln')

@section('title', 'Senarai Pic Jabatan')

@section('link')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
<!-- DataTables -->
<script src="{{ asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>

@endsection

@section('content')
@include('flash::message')
 <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Senarai Permohonan</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>MyID</th>
                  <th>Jabatan</th>
                  <th>Email</th>
                  <th>Tindakan</th>
                </tr>
                </thead>

                @php
                  $no=1;
                @endphp

                <tbody>
               @foreach($user as $users)
                <tr>
                  <td>@php
                    echo $no;
                    $no=$no+1;
                  @endphp</td>
                  <td>{{$users->nama}}</td>
                  <td>{{$users->nokp}}</td>
                  <td>{{$users->jabatan}}</td>
                  <td>{{ $users->email }}</td>
                  <td><a href="/senaraiPIC/{{ $users->usersID }}/edit"><button type="button" class="btn btn-warning" onclick="return confirm('Adakah anda pasti untuk mengemaskini?')">Edit</button></a></td>
                  
                  
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
            
@endsection

@section('script')
      <script>
        $(function () {
          $('#example1').DataTable()
          $('#example2').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false
          })
        })
      </script>
@endsection




