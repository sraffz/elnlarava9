@extends('layouts.eln')

@section('title', 'Senarai Permohonan')

@section('link')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('adminlte-3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <style>
        table th {
            font-size: 15px;
            font-weight: bold;
        }

        .table tr td {
            font-size: 15px;
            font-weight: bold;
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
                    <h3 class="box-title">Senarai Permohonan</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Halaman Utama</a></li>
                        <li class="breadcrumb-item active">Senarai Permohonan</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @include('flash::message')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Senarai Permohonan individu</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-striped display">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Negara</th>
                                        <th>Tarikh Mula Perjalanan</th>
                                        <th>Tarikh Akhir Perjalanan</th>
                                        <th>Jenis/Tujuan</th>
                                        <th>Status Permohonan</th>
                                        <th>Tarikh Lulusan</th>
                                        <th style="width: 13%">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permohonan as $index => $mohonan)
                                    @php
                                        $id = Hashids::encode($mohonan->permohonansID);
                                    @endphp
                                        <tr class="text-center">
                                            <td>
                                                {{ $index + 1 }}
                                            </td>
                                            <td>
                                                <a
                                                    href='{{ url('detailPermohonan', [$id]) }}'>
                                                    {{ $mohonan->negara }}@if ($mohonan->negara_lebih_dari_satu == 1){{', '.$mohonan->negara_tambahan }}@endif
                                                </a>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($mohonan->tarikhMulaPerjalanan)->format('d/m/Y') }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($mohonan->tarikhAkhirPerjalanan)->format('d/m/Y') }}
                                            </td>
                                            <td>{{ $mohonan->lainTujuan }}<br>({{ $mohonan->JenisPermohonan }})</td>
                                            <td>
                                                @if ($mohonan->statusPermohonan == 'simpanan')
                                                    <span class="badge badge-info">Draf</span>
                                                @elseif($mohonan->statusPermohonan == 'Lulus Semakkan ketua Jabatan')
                                                    <span class="badge badge-info">Tindakan BPSM</span>
                                                @elseif($mohonan->statusPermohonan == 'Permohonan Berjaya')
                                                    @if ($mohonan->statusPermohonanRom == 'Permohonan Gagal')
                                                        <span class="badge badge-danger">Gagal</span>
                                                    @else
                                                        <span class="badge badge-success">Berjaya</span>
                                                    @endif
                                                @elseif($mohonan->statusPermohonan == 'Permohonan Gagal')
                                                    <span class="badge badge-danger">Gagal</span>
                                                @else
                                                    <span
                                                        class="badge badge-info">{{ $mohonan->statusPermohonan }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (is_null($mohonan->tarikhLulusan))
                                                    <span class="badge badge-info">Tiada tarikh</span>
                                                @else
                                                    <span
                                                        class="badge badge-primary">{{ \Carbon\Carbon::parse($mohonan->tarikhLulusan)->format('d/m/Y') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($mohonan->statusPermohonan == 'Pending')
                                                    <span class="badge badge-warning">Pending</span>
                                                @elseif($mohonan->statusPermohonan == 'simpanan')
                                                    <a href='{{ url("/senaraiPermohonan/{$mohonan->permohonansID}/hantarIndividu") }}'
                                                        class="btn btn-success btn-xs"
                                                        onclick="javascript: return confirm('Adakah anda pasti untuk menghantar maklumat permohonan?');"><i
                                                            class="fa fa-check-square-o"></i></a>

                                                    <a href='{{ url("senaraiPermohonan/{$mohonan->permohonansID}/kemaskini") }}'
                                                        class="btn btn-info btn-xs"
                                                        onclick="javascript: return confirm('Adakah anda pasti untuk mengemaskini maklumat permohonan?');"><i
                                                            class="fas fa-edit"></i></a>

                                                    <a href='{{ url("senaraiPermohonan/{$mohonan->permohonansID}/hapus") }}'
                                                        class="btn btn-danger btn-xs"
                                                        onclick="javascript: return confirm('Padam maklumat ini?');"><i
                                                            class="fa fa-user-times"></i></a>
                                                @elseif($mohonan->statusPermohonan == 'Permohonan Berjaya')
                                                    @if ($mohonan->JenisPermohonan == 'Rasmi')
                                                        @if ($mohonan->surat = 'MEMO')
                                                            <a href="{{ route('memoRasmi', ['id' => $mohonan->permohonansID]) }}"
                                                                class="btn btn-primary btn-xs">
                                                                Memo
                                                            </a>
                                                        @elseif ($mohonan->surat = 'SURAT')
                                                            <a href="{{ route('suratRasmi', ['id' => $mohonan->permohonansID]) }}"
                                                                class="btn btn-primary btn-xs">
                                                                Surat
                                                            </a>
                                                        @endif
                                                        <div class="mt-2">
                                                        </div>
                                                    @elseif($mohonan->JenisPermohonan == 'Tidak Rasmi')
                                                        @if ($mohonan->surat = 'MEMO')
                                                            <a href="{{ route('memoTidakRasmi', ['id' => $mohonan->permohonansID]) }}"
                                                                class="btn btn-primary btn-xs">
                                                                Memo
                                                            </a>
                                                        @elseif ($mohonan->surat = 'SURAT')
                                                            <a href="{{ route('suratTidakRasmi', ['id' => $mohonan->permohonansID]) }}"
                                                                class="btn btn-primary btn-xs">
                                                                Surat
                                                            </a>
                                                        @endif
                                                        <div class="mt-2">
                                                        </div>
                                                    @elseif($mohonan->JenisPermohonan == 'rombongan')
                                                        {{-- <a href="{{ route('surat-rombongan', ['id' => $mohonan->rombongans_id]) }}"
                                                            class="btn btn-primary btn-xs">
                                                            Surat
                                                        </a>
                                                        <a href="{{ route('memo-rombongan', ['id' => $mohonan->rombongans_id]) }}"
                                                            class="btn btn-primary btn-xs">
                                                            Memo
                                                        </a> --}}
                                                    @endif
                                                    @if ($mohonan->pengesahan_pembatalan == 1)
                                                        <button type="button" class="btn btn-info btn-xs"
                                                            data-toggle="modal"
                                                            data-sebab="{{ $mohonan->sebab_pembatalan }}"
                                                            data-tarikh="{{ \Carbon\Carbon::parse($mohonan->tarikh_batal)->format('d-m-Y') }}"
                                                            data-target="#detailbatal">
                                                            <i class="fa fa-info-circle"></i> Sebab Batal
                                                        </button>
                                                    @else
                                                        @if ($mohonan->tarikhAkhirPerjalanan >= \Carbon\Carbon::now()->format('Y-m-d'))
                                                            <button type="button" class="btn btn-dark btn-xs"
                                                                data-toggle="modal"
                                                                data-id="{{ $mohonan->permohonansID }}"
                                                                data-target="#batalpermohonan">
                                                                Batal Permohonan
                                                            </button>
                                                        @else
                                                        @endif
                                                    @endif
                                                @elseif($mohonan->statusPermohonan == 'Permohonan Gagal')
                                                    {{-- <span class="badge badge-danger">Gagal</span> --}}
                                                    @if ($mohonan->JenisPermohonan == 'Rasmi')
                                                        @if ($mohonan->surat = 'MEMO')
                                                            <a href="{{ route('memoRasmi', ['id' => $mohonan->permohonansID]) }}"
                                                                class="btn btn-primary btn-xs">
                                                                Memo
                                                            </a>
                                                        @elseif ($mohonan->surat = 'SURAT')
                                                            <a href="{{ route('suratRasmi', ['id' => $mohonan->permohonansID]) }}"
                                                                class="btn btn-primary btn-xs">
                                                                Surat
                                                            </a>
                                                        @endif
                                                        <div class="mt-2"></div>
                                                    @elseif($mohonan->JenisPermohonan == 'Tidak Rasmi')
                                                        @if ($mohonan->surat = 'MEMO')
                                                            <a href="{{ route('memoTidakRasmi', ['id' => $mohonan->permohonansID]) }}"
                                                                class="btn btn-primary btn-xs">
                                                                Memo
                                                            </a>
                                                            <div class="mt-2"></div>
                                                        @elseif ($mohonan->surat = 'SURAT')
                                                            <a href="{{ route('suratTidakRasmi', ['id' => $mohonan->permohonansID]) }}"
                                                                class="btn btn-primary btn-xs">
                                                                Surat
                                                            </a>
                                                        @endif
                                                    @elseif($mohonan->JenisPermohonan == 'rombongan')
                                                        {{-- <a href="{{ route('surat-rombongan', ['id' => $mohonan->rombongans_id]) }}"
                                                            class="btn btn-primary btn-xs">
                                                            Surat
                                                        </a>
                                                        <a href="{{ route('memo-rombongan', ['id' => $mohonan->rombongans_id]) }}"
                                                            class="btn btn-primary btn-xs">
                                                            Memo
                                                        </a> --}}
                                                    @endif
                                                @else
                                                    <span class="badge badge-primary">Tiada</span>
                                                @endif
                                            </td>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Batal Permohonan -->
        <div class="modal fade" id="batalpermohonan" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Pembatalan Permohonan Keluar Negara</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('batal-permohonan') }}" method="post">
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" id="id" value="">
                            <div class="form-group">
                                <label for="sebab_batal">Nyatakan Sebab Pembatalan</label>
                                <textarea class="form-control {{ $errors->has('sebab_batal') ? ' is-invalid' : '' }}" name="sebab_batal"
                                    id="sebab_batal" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Batal Permohonan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal Detail Pembatalan Permohonan-->
        <div class="modal fade" id="detailbatal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Butiran Pembatalan Permohonan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="form-group">
                                <label for="tarikh">Tarikh Pembatalan</label>
                                <input type="text" disabled class="form-control" name="tarikh" id="tarikh">
                            </div>
                            <div class="form-group">
                                <label for="sebab">Sebab Pembatalan</label>
                                <textarea style="resize: none" class="form-control" name="sebab" disabled id="sebab" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
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
        $('#detailbatal').on('show.bs.modal', event => {
            var button = $(event.relatedTarget);
            var modal = $(this);
            var sebab = button.data('sebab');
            var tarikh = button.data('tarikh');
            // Use above variables to manipulate the DOM

            $(".modal-body #sebab").val(sebab);
            $(".modal-body #tarikh").val(tarikh);
        });

        $('#batalpermohonan').on('show.bs.modal', event => {
            var button = $(event.relatedTarget);
            var modal = $(this);
            var id = button.data('id');
            // Use above variables to manipulate the DOM
            $(".modal-body #id").val(id);
        });
    </script>
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
