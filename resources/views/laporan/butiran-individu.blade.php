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
                    <h1>Laporan Individu</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Laporan Individu</li>
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
                        <div class="card-header ">
                            <div class="float-left">
                                <a type="button" href="{{ url('laporan-individu') }}" class="btn btn-danger btn-sm">
                                    <i class="fa fa-chevron-left"></i> KEMBALI
                                </a>
                            </div>
                            <div class="float-right">
                                <a type="button" href="{{ url('cetak-butiran-individu', [$user->usersID]) }}" class="btn btn-dark btn-sm">
                                    <i class="fa fa-print"></i> CETAK
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Nama</label>
                                        <input type="text" class="form-control" disabled value="{{ $user->nama }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Kad Pengenalan</label>
                                        <input type="text" class="form-control" disabled value="{{ $user->nokp }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Jawatan & Gred</label>
                                        <textarea style="resize: none" class="form-control" cols="30" rows="2"
                                            disabled>{{ $user->namaJawatan }} ({{ $user->kod }}{{ $user->gred }})</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Jabatan</label>
                                        <textarea style="resize: none" class="form-control" cols="30" rows="2"
                                            disabled>{{ $user->nama_jabatan }} ({{ $user->kod_jabatan }})</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header ">
                            <div class="float-left">
                                Sejarah Keluar Negara
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
                                                <th style="vertical-align: middle">NEGARA</th>
                                                <th style="vertical-align: middle">JENIS PERMOHONAN</th>
                                                <th style="vertical-align: middle">TEMPOH PERJALANAN</th>
                                                <th style="vertical-align: middle">TARIKH LULUS</th>
                                                <th style="vertical-align: middle">STATUS PERMOHONAN</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($negara as $dd)
                                                <tr class="text-center">
                                                    <td style="vertical-align: middle">{{ $i++ }}</td>
                                                    <td class="text-left" style="vertical-align: middle">
                                                        {{ $dd->negara }}</td>
                                                    <td style="vertical-align: middle">{{ $dd->JenisPermohonan }}</td>
                                                    @php
                                                        $formatted_dt1 = \Carbon\Carbon::parse($dd->tarikhMulaPerjalanan);
                                                        
                                                        $formatted_dt2 = \Carbon\Carbon::parse($dd->tarikhAkhirPerjalanan);
                                                        
                                                        $beza = $formatted_dt1->diffInDays($formatted_dt2);
                                                    @endphp
                                                    <td style="vertical-align: middle">
                                                        {{ \Carbon\Carbon::parse($dd->tarikhMulaPerjalanan)->format('d/m/y') }}
                                                        -
                                                        {{ \Carbon\Carbon::parse($dd->tarikhAkhirPerjalanan)->format('d/m/y') }}
                                                        ({{ $beza }} Hari)</td>
                                                    <td style="vertical-align: middle">{{ \Carbon\Carbon::parse($dd->tarikhLulusan)->format('d/m/y') }}</td>
                                                    <td style="vertical-align: middle">
                                                        @if ($dd->status_rombongan == 'Permohonan Gagal')
                                                            Gagal
                                                        @else
                                                            {{ substr($dd->statusPermohonan, 11) }}
                                                            @if ($dd->pengesahan_pembatalan == 1)
                                                                (DIBATALKAN)
                                                            @endif
                                                            
                                                        @endif
                                                    </td>
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
