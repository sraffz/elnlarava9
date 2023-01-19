@extends('layouts.eln')

@section('title', 'Jumlah Keluar Negera')

@section('link')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('adminlte-3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <style>
        .table td {
            font-weight: bold;
            text-transform: uppercase;
            vertical-align: middle;
        }

    </style>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Laporan Mengikut Bulan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Laporan Mengikut Bulan</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('flash::message')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a class="btn btn-danger btn-sm" href="{{ url()->previous() }}" role="button"><i class="fa fa-chevron-left"></i> KEMBALI</a>
                        </div>
                        <div class="card-body">
                            <form method="get" action="{{ route('laporan-butiran-bulanan2') }}">
                                {{-- {{ csrf_field() }} --}}
                                <div class="col-md-4 offset-md-4 text-center">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="bulan">Bulan</label>
                                            <select class="form-control" name="bulan" id="bulan">
                                                <option value="">Pilih</option>
                                                <option value='1' {{ $bulan == 1 ? 'selected' : '' }}>Januari</option>
                                                <option value='2' {{ $bulan == 2 ? 'selected' : '' }}>Februari</option>
                                                <option value='3' {{ $bulan == 3 ? 'selected' : '' }}>Mac</option>
                                                <option value='4' {{ $bulan == 4 ? 'selected' : '' }}>April</option>
                                                <option value='5' {{ $bulan == 5 ? 'selected' : '' }}>Mei</option>
                                                <option value='6' {{ $bulan == 6 ? 'selected' : '' }}>Jun</option>
                                                <option value='7' {{ $bulan == 7 ? 'selected' : '' }}>Julai</option>
                                                <option value='8' {{ $bulan == 8 ? 'selected' : '' }}>Ogos</option>
                                                <option value='9' {{ $bulan == 9 ? 'selected' : '' }}>September</option>
                                                <option value='10' {{ $bulan == 10 ? 'selected' : '' }}>Oktober</option>
                                                <option value='11' {{ $bulan == 11 ? 'selected' : '' }}>November</option>
                                                <option value='12' {{ $bulan == 12 ? 'selected' : '' }}>Disember</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="tahun">Tahun</label>
                                            <select class="form-control" name="tahun" id="tahun">
                                                <option value="">Pilih</option>
                                                @foreach ($listyear as $ly)
                                                    <option value="{{ $ly->tahun }}" {{ $tahun == $ly->tahun ? 'selected' : '' }}>{{ $ly->tahun }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-primary">Papar</button>
                                    {{-- <a class="btn btn-info" href="{{ route('laporanJabatan', [$tahun]) }}">Cetak Laporan</a> --}}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header with-border">
                            <div class="float-left">
                                <h5><strong>JUMLAH KESELURUHAN : </strong></h5>
                            </div>
                            <div class="float-right">
                                {{-- <a type="button" href="{{ route('laporanBulanan', [$tahun]) }}"
                                    class="btn btn-dark">Cetak
                                    Laporan
                                </a> --}}
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="vertical-align: middle">BIL</th>
                                                <th style="vertical-align: middle">NAMA / NO. KP / JAWATAN</th>
                                                <th style="vertical-align: middle">BAHAGIAN/AGENSI</th>
                                                <th style="vertical-align: middle">JENIS PERMOHONAN</th>
                                                <th style="vertical-align: middle">NEGERA</th>
                                                <th style="vertical-align: middle">TEMPOH PERJALANAN</th>
                                            </tr>
                                        </thead>
                                       <tbody>
                                           @php
                                               $f=1;
                                           @endphp
                                        @foreach ($list as $ls)
                                            <tr class="text-center">
                                                <td>{{ $f++ }}</td>
                                                <td class="text-left">{{ $ls->nama }} <br> {{  $ls->nokp }} <br> {{ $ls->jawatan_pemohon }}</td>
                                                <td>{{  $ls->nama_jabatan }}</td>
                                                <td>{{  $ls->JenisPermohonan }}</td>
                                                <td>{{  $ls->negara }}</td>
                                                <td>{{  \Carbon\Carbon::parse($ls->tarikhMulaPerjalanan)->format('d/m/y') }} - {{ \Carbon\Carbon::parse($ls->tarikhAkhirPerjalanan)->format('d/m/y') }}</td>
                                            </tr>
                                        @endforeach
                                       </tbody>
                                    </table>
                                    <!-- /.chart-responsive -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- ./card-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
        </div>
    </section>

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
            $('table.data').DataTable({
                "order": [
                    [1, "desc"]
                ],
                "pageLength": 10,
                "lengthMenu": [10, 20, 50, 100],
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
