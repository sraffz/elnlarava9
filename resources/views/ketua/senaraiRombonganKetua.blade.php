@extends('layouts.eln')

@section('title', 'Senarai Rombongan')

@section('link')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Senarai Permohonan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Senarai Permohonan</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('flash::message')
                    <div class="card">
                        <div class="card-header with-border">
                            <h3 class="card-title">Senarai Rombongan</h3>
                            <div class="float-right">
                                <a class="btn btn-dark btn-sm" href="{{ url('cetak-senarai-rombongan') }}"
                                    role="button">Cetak</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-striped display">
                                        <thead>
                                            <tr>
                                                <th>Bil</th>
                                                <th>Negara</th>
                                                <th>Code</th>
                                                <th>Tarikh Mula Perjalanan</th>
                                                <th>Tarikh Akhir Perjalanan</th>
                                                <th>Tujuan Rombongan</th>
                                                <th>Peserta</th>
                                                {{-- <th>Status Permohonan</th> --}}
                                                {{-- <th>Tarikh Lulusan Permohonan</th> --}}
                                                <th>Tindakan</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($rombongan as $index => $rombo)
                                                @php
                                                    $first_datetime = new DateTime($rombo->tarikhMulaRom);
                                                    $last_datetime = new DateTime(now());
                                                    $interval = $first_datetime->diff($last_datetime);
                                                    $final_days = $interval->format('%a'); //and then print do whatever you like with $final_days
                                                    $id = Hashids::encode($rombo->rombongans_id);
                                                @endphp

                                                @if ($first_datetime >= $last_datetime)
                                                    @if ($final_days < 7)
                                                        <tr class="bg-gradient-danger">
                                                            {{-- <tr style="background-color:#e46868"> --}}
                                                        @elseif ($final_days < 10)
                                                        <tr class="bg-gradient-warning">
                                                        @else
                                                        <tr>
                                                    @endif
                                                @else
                                                    {{-- <tr style="background-color:#e46868"> --}}
                                                    <tr class="bg-gradient-danger">
                                                @endif

                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <a
                                                        href="{{ url('detailPermohonanRombongan', [$id]) }}">{{ $rombo->negaraRom }}</a>
                                                </td>
                                                <td>{{ $rombo->codeRom }}</td>
                                                <td>{{ \Carbon\Carbon::parse($rombo->tarikhMulaRom)->format('d/m/Y') }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($rombo->tarikhAkhirRom)->format('d/m/Y') }}
                                                </td>
                                                <td>{{ $rombo->tujuanRom }}</td>
                                                <td>
                                                    {{-- {{ $rombo->nama }} <br> --}}
                                                    @foreach ($allPermohonan as $element)
                                                        @if ($element->rombongans_id == $rombo->rombongans_id)
                                                            {{ $element->user->nama }} &nbsp;&nbsp;

                                                            @if ($rombo->statusPermohonanRom == 'Permohonan Berjaya')
                                                                {{-- <a class="btn-warning btn-xs disabled"><i class="fa fa-times-circle"></i></a><br> --}}
                                                                <br>
                                                            @elseif($rombo->statusPermohonanRom == 'Lulus Semakan')
                                                                <a href="{{ url('tolak-permohonan', [$element->permohonansID]) }}"
                                                                    class="btn-danger btn-xs"
                                                                    onclick="javascript: return confirm('Tolak Permohonan?');"><i
                                                                        class="fa  fa-times"></i></a><br>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </td>
                                                {{-- <td>{{ $rombo->statusPermohonanRom }}</td> --}}
                                                {{-- <td>{{\Carbon\Carbon::parse($rombo->tarikhLulusan)->format('d/m/Y')}}</td> --}}
                                                <td>
                                                    @if ($rombo->statusPermohonanRom == 'Permohonan Berjaya')
                                                        <span class="label label-success">Berjaya</span>
                                                    @elseif($rombo->statusPermohonanRom == 'Lulus Semakan')
                                                        <a href="{{ url('luluskan-rombongan', [$rombo->rombongans_id]) }}"
                                                            class="btn btn-success btn-xs"
                                                            onclick="javascript: return confirm('Adakah anda pasti untuk menluluskan permohonan ini?');"><i
                                                                class="fa fa-thumbs-up"></i></a>

                                                        <a href="{{ url('tolak-rombongan', [$rombo->rombongans_id]) }}"
                                                            class="btn btn-danger btn-xs"
                                                            onclick="javascript: return confirm('Anda pasti untuk menolak permohonan ini?');"><i
                                                                class="fa fa-thumbs-down"></i></a>

                                                        <a href="{{ route('cetak-butiran-rombongan', [$rombo->rombongans_id]) }}"
                                                            class="btn btn-dark btn-xs">
                                                            <i class="fa fa-print"></i>
                                                        </a>
                                                    @elseif($rombo->statusPermohonanRom == 'Permohonan Diluluskan')
                                                        <span class="label label-success">Diluluskan</span>
                                                    @elseif(
                                                        $rombo->statusPermohonanRom == 'Permohonan Diluluskan' or
                                                            $rombo->statusPermohonanRom == 'Permohonan Ditolak' or
                                                            $rombo->statusPermohonanRom == 'Lulus Semakan')
                                                        <span class="label label-primary">Tiada</span>
                                                    @endif
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
