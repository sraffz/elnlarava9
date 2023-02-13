@extends('layouts.eln')

@section('title', 'eKeluarNegara')

@section('link')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('adminlte-3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <style>
        .table tr th {
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
                            <h3 class="card-title">Senarai Permohonan Individu<br>
                                {{-- <small>Tidak termasuk individu yg mengikut rombongan</small> --}}
                            </h3>
                            <div class="float-right">
                                <a class="btn btn-dark btn-sm" href="{{ url('cetak-senarai-permohonan') }}"
                                    role="button">Cetak</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-striped display">
                                        <thead class="thead-primary">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Jabatan</th>
                                                <th>Tarikh Permohonan</th>
                                                <th>Negara</th>
                                                <th>Tarikh Mula Perjalanan</th>
                                                <th>Jenis Permohonan</th>
                                                <th>Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($permohonan as $mohonan)
                                                @php
                                                    $first_datetime = new DateTime($mohonan->tarikhMulaPerjalanan);
                                                    $last_datetime = new DateTime(now());
                                                    $interval = $first_datetime->diff($last_datetime);
                                                    $final_days = $interval->format('%a'); //and then print do whatever you like with $final_days
                                                @endphp

                                                @if ($first_datetime >= $last_datetime)
                                                    @if ($final_days < 7)
                                                        <tr class="bg-gradient-danger text-center">
                                                        @elseif ($final_days < 10)
                                                        <tr class="bg-gradient-warning text-center">
                                                        @else
                                                        <tr>
                                                    @endif
                                                @else
                                                    <tr class="bg-gradient-danger">
                                                @endif
                                                <td class="text-center">
                                                    {{ $i++ }}
                                                </td>
                                                <td style="text-transform: capitalize; font-weight: bold">
                                                    <a href="{{ url('detailPermohonan', [$mohonan->permohonansID]) }}">{{ $mohonan->nama }}</a>
                                                </td>
                                                <td class="text-center">{{ $mohonan->kod_jabatan }}</td>
                                                <td class="text-center">{{ \Carbon\Carbon::parse($mohonan->tarikhmohon)->format('d/m/Y') }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $mohonan->negara }}@if ($mohonan->negara_lebih_dari_satu == 1){{ ', '.$mohonan->negara_tambahan }}
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ \Carbon\Carbon::parse($mohonan->tarikhMulaPerjalanan)->format('d/m/Y') }}
                                                </td>
                                                {{-- <td>{{\Carbon\Carbon::parse($mohonan->tarikhAkhirPerjalanan)->format('d/m/Y')}}</td> --}}
                                                <td class="text-center">{{ $mohonan->JenisPermohonan }}</td>
                                                <td class="text-center">
                                                    @if ($mohonan->statusPermohonan == 'Lulus Semakan BPSM')

                                                        <a href="{{ route('senaraiPermohonan.hantar', ['id' => $mohonan->permohonansID]) }}"
                                                            class="btn btn-success btn-xs"
                                                            onclick="javascript: return confirm('Anda pasti untuk meluluskan Semakan permohonan ini?');">
                                                            <i class="far fa-thumbs-up"></i>
                                                        </a>
                                                        <a href="{{ route('senaraiPermohonan.tolakPermohonan', ['id' => $mohonan->permohonansID]) }}"
                                                            class="btn btn-danger btn-xs"
                                                            onclick="javascript: return confirm('Anda pasti untuk menolak permohonan ini?');"><i
                                                                class="far fa-thumbs-down"></i>
                                                        </a>
                                                        <a href="{{ url('cetak-butiran-permohonan', [$mohonan->permohonansID]) }}"
                                                            class="btn btn-dark btn-xs">
                                                            <i class="fa fa-print"></i>
                                                        </a>
                                                        <hr class="mt-1 mb-1"> 
                                                        @if ($mohonan->JenisPermohonan == 'Rasmi')
                                                        Rasmi : 
                                                            @foreach ($dokumen as $doc)
                                                                @if ($mohonan->permohonansID == $doc->permohonansID)
                                                                    <a class="btn btn-xs btn-primary" href="{{ route('detailPermohonanDokumen.download', ['id' => $doc->dokumens_id]) }}" target="blank"><i class="far fa-file-alt"></i></a>
                                                                @endif
                                                            @endforeach
                                                        @elseif ($mohonan->JenisPermohonan == 'Tidak Rasmi')
                                                            {{-- {{ $mohonan->pathFileCuti }} --}}
                                                            Tidak Rasmi : 
                                                            <a class="btn btn-xs btn-info" href="{{ route('detailPermohonan.download', ['id' => $mohonan->permohonansID]) }}" target="blank"><i class="far fa-file-alt"></i></a>
                                                        @endif
                                                        @if ($dokumen_sokongan ?? '')
                                                            <hr class="mt-1 mb-1">
                                                            Sokongan :
                                                            @foreach ($dokumen_sokongan as $doc)
                                                                @if ($mohonan->permohonansID == $doc->permohonansID)
                                                                    <a class="btn btn-xs btn-danger"
                                                                        href="{{ route('detailPermohonanDokumensokongan.download', ['id' => $doc->dokumens_id_sokongan]) }}"
                                                                        target="blank"><i class="far fa-file-alt"></i></a>
                                                                @else
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @elseif($mohonan->statusPermohonan == 'Permohonan Berjaya')
                                                        <a href="{{ url('cetak-butiran-permohonan', [$mohonan->permohonansID]) }}"
                                                            class="btn btn-dark btn-xs">
                                                            <i class="fa fa-print"></i>
                                                        </a>
                                                    @elseif($mohonan->statusPermohonan == 'Permohonan Gagal')
                                                        <a href="{{ url('cetak-butiran-permohonan', [$mohonan->permohonansID]) }}"
                                                            class="btn btn-dark btn-xs">
                                                            <i class="fa fa-print"></i>
                                                        </a>
                                                    @endif
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
