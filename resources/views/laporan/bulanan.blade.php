@extends('layouts.eln')

@section('title', 'Jumlah Keluar Negera')

@section('link')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('adminlte-3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <style>
        table td {
            font-weight: bold;
            text-transform: uppercase;
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
                        <div class="card-body">
                            <form method="get" action="{{ url('laporan-bulanan') }}">
                                {{-- {{ csrf_field() }} --}}
                                <div class="form-group">
                                    <label for="tahun">Tahun</label>
                                    <select class="form-control" name="tahun" id="tahun">
                                        @foreach ($listyear as $ly)
                                            <option value="{{ $ly->tahun }}"
                                                {{ $tahun == $ly->tahun ? 'selected' : '' }}>{{ $ly->tahun }}</option>
                                        @endforeach
                                    </select>
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
                                <h5><strong>JUMLAH KESELURUHAN : {{ $jumlah }}</strong></h5>
                            </div>
                            <div class="float-right">
                                <a type="button" href="{{ route('laporanBulanan', [$tahun]) }}"
                                    class="btn btn-dark">Cetak
                                    Laporan
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th style="vertical-align: middle">BULAN</th>
                                                <th style="vertical-align: middle">JUMLAH</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td class="text-center">Januari</td>
                                                <td class="text-center">
                                                    @foreach ($bil as $jbil)
                                                        @if ($jbil->bulan == 1)
                                                            {{ $jbil->bil }}
                                                            &nbsp;&nbsp;
                                                            <a href="{{ route('laporan-butiran-bulanan', [$tahun, $jbil->bulan]) }}"><span class="badge badge-primary">Butiran</span></a>
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="text-center">Febuari</td>
                                                <td class="text-center">
                                                    @foreach ($bil as $jbil)
                                                        @if ($jbil->bulan == 2)
                                                            {{ $jbil->bil }}
                                                            &nbsp;&nbsp;
                                                            <a href="{{ route('laporan-butiran-bulanan', [$tahun, $jbil->bulan]) }}"><span class="badge badge-primary">Butiran</span></a>
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Mac</td>
                                                <td class="text-center">
                                                    @foreach ($bil as $jbil)
                                                        @if ($jbil->bulan == 3)
                                                            {{ $jbil->bil }}
                                                            &nbsp;&nbsp;
                                                            <a href="{{ route('laporan-butiran-bulanan', [$tahun, $jbil->bulan]) }}"><span class="badge badge-primary">Butiran</span></a>
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">April</td>
                                                <td class="text-center">
                                                    @foreach ($bil as $jbil)
                                                        @if ($jbil->bulan == 4)
                                                            {{ $jbil->bil }}
                                                            &nbsp;&nbsp;
                                                            <a href="{{ route('laporan-butiran-bulanan', [$tahun, $jbil->bulan]) }}"><span class="badge badge-primary">Butiran</span></a>
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Mei</td>
                                                <td class="text-center">
                                                    @foreach ($bil as $jbil)
                                                        @if ($jbil->bulan == 5)
                                                            {{ $jbil->bil }}
                                                            &nbsp;&nbsp;
                                                            <a href="{{ route('laporan-butiran-bulanan', [$tahun, $jbil->bulan]) }}"><span class="badge badge-primary">Butiran</span></a>
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Jun</td>
                                                <td class="text-center">
                                                    @foreach ($bil as $jbil)
                                                        @if ($jbil->bulan == 6)
                                                            {{ $jbil->bil }}
                                                            &nbsp;&nbsp;
                                                            <a href="{{ route('laporan-butiran-bulanan', [$tahun, $jbil->bulan]) }}"><span class="badge badge-primary">Butiran</span></a>
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Julai</td>
                                                <td class="text-center">
                                                    @foreach ($bil as $jbil)
                                                        @if ($jbil->bulan == 7)
                                                            {{ $jbil->bil }}
                                                            &nbsp;&nbsp;
                                                            <a href="{{ route('laporan-butiran-bulanan', [$tahun, $jbil->bulan]) }}"><span class="badge badge-primary">Butiran</span></a>
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Ogos</td>
                                                <td class="text-center">
                                                    @foreach ($bil as $jbil)
                                                        @if ($jbil->bulan == 8)
                                                            {{ $jbil->bil }}
                                                            &nbsp;&nbsp;
                                                            <a href="{{ route('laporan-butiran-bulanan', [$tahun, $jbil->bulan]) }}"><span class="badge badge-primary">Butiran</span></a>
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">September</td>
                                                <td class="text-center">
                                                    @foreach ($bil as $jbil)
                                                        @if ($jbil->bulan == 9)
                                                            {{ $jbil->bil }}
                                                            &nbsp;&nbsp;
                                                            <a href="{{ route('laporan-butiran-bulanan', [$tahun, $jbil->bulan]) }}"><span class="badge badge-primary">Butiran</span></a>
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Oktober</td>
                                                <td class="text-center">
                                                    @foreach ($bil as $jbil)
                                                        @if ($jbil->bulan == 10)
                                                            {{ $jbil->bil }}
                                                            &nbsp;&nbsp;
                                                            <a href="{{ route('laporan-butiran-bulanan', [$tahun, $jbil->bulan]) }}"><span class="badge badge-primary">Butiran</span></a>
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">November</td>
                                                <td class="text-center">
                                                    @foreach ($bil as $jbil)
                                                        @if ($jbil->bulan == 11)
                                                            {{ $jbil->bil }}
                                                            &nbsp;&nbsp;
                                                            <a href="{{ route('laporan-butiran-bulanan', [$tahun, $jbil->bulan]) }}"><span class="badge badge-primary">Butiran</span></a>
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="text-center">Disember</td>
                                                <td class="text-center">
                                                    @foreach ($bil as $jbil)
                                                        @if ($jbil->bulan == 12)
                                                            {{ $jbil->bil }}
                                                            &nbsp;&nbsp;
                                                            <a href="{{ route('laporan-butiran-bulanan', [$tahun, $jbil->bulan]) }}"><span class="badge badge-primary">Butiran</span></a>
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
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
