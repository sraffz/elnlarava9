@extends('layouts.eln', ['activePage' => 'senaraipending'])

@section('title', 'Senarai Keputusan')

@section('link')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('adminlte-3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
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
    <section class="content">
        <div class="container-fluid">
            @php
                $url = url()->current();
                // echo $url;
            @endphp
            <div class="row">
                <div class="col-md-12">
                    @include('flash::message')
                    <div class="card">
                        <div class="card-header with-border">
                            @if ($url != url('senaraiRekodIndividu'))
                                <h3 class="card-title">Senarai Permohonan Individu<br><small>Tidak termasuk individu yg
                                        mengikut
                                        rombongan</small> </h3>
                            @else
                                <h3 class="card-title">Rekod Permohonan</h3>
                            @endif
                        </div>
                        <!-- /.box-header -->
                        {{-- <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm display">
                                            <thead>
                                                <tr class="text-center">
                                                    <th style="vertical-align: middle">No</th>
                                                    <th style="vertical-align: middle">Nama</th>
                                                    <th style="vertical-align: middle">Jabatan</th>
                                                    <th style="vertical-align: middle">Negara</th>
                                                    <th style="vertical-align: middle">Tarikh Permohonan</th>
                                                    <th style="vertical-align: middle">Tarikh Mula Perjalanan</th>
                                                    <th style="vertical-align: middle">Tarikh Kelulusan</th>
                                                    <th style="vertical-align: middle">Jenis Permohonan</th>
                                                    <th style="vertical-align: middle">Status Permohonan</th>
                                                    @if ($url != url('senaraiRekodIndividu'))
                                                        <th style="vertical-align: middle">Tindakan</th>
                                                    @else
                                                        <th style="vertical-align: middle">Dokumen(Cetak)</th>
                                                    @endif
                                                </tr>
                                            </thead>

                                            <tbody>

                                                @foreach ($permohonan as $index => $mohonan)
                                                    <tr class="text-center">
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            <a
                                                                href="{{ url('detailPermohonan', [$mohonan->permohonansID]) }}">{{ $mohonan->user->nama }}</a>
                                                        </td>
                                                        <td>{{ $mohonan->user->userJabatan->kod_jabatan }}</td>
                                                        <td>{{ $mohonan->negara }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($mohonan->created_at)->format('d/m/Y') }}
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($mohonan->tarikhMulaPerjalanan)->format('d/m/Y') }}
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($mohonan->tarikhLulusan)->format('d/m/Y') }}
                                                        </td>
                                                        <td>
                                                            {{ $mohonan->JenisPermohonan }}

                                                        </td>
    
                                                        @if ($mohonan->statusPermohonan == 'Permohonan Berjaya')
                                                            <td>
                                                                <span
                                                                    class="badge badge-success">{{ $mohonan->statusPermohonan }}</span>
                                                                @if ($mohonan->pengesahan_pembatalan == 1)
                                                                    <button type="button" class="btn btn-primary btn-xs"
                                                                        data-toggle="modal"
                                                                        data-sebab="{{ $mohonan->sebab_pembatalan }}"
                                                                        data-tarikh="{{ \Carbon\Carbon::parse($mohonan->tarikh_batal)->format('d-m-Y') }}"
                                                                        data-target="#detailbatal">
                                                                        <i class="fa fa-info-circle"></i> Dibatalkan
                                                                    </button>
                                                                @endif
                                                            </td>

                                                            @if ($mohonan->JenisPermohonan == 'Rasmi')
                                                                <td class="text-center">

                                                                    <a href="{{ route('suratRasmi', ['id' => $mohonan->permohonansID]) }}"
                                                                        class="btn btn-primary btn-xs">
                                                                        Surat
                                                                    </a>
                                                                    <a href="{{ route('memoRasmi', ['id' => $mohonan->permohonansID]) }}"
                                                                        class="btn btn-primary btn-xs">
                                                                        Memo
                                                                    </a>
                                                                </td>

                                                            @elseif($mohonan->JenisPermohonan == 'Tidak Rasmi')
                                                                <td class="text-center">
                                                                    {{ $mohonan->user->jabatan }}
                                                                    <a href="{{ route('suratTidakRasmi', ['id' => $mohonan->permohonansID]) }}"
                                                                        class="btn btn-primary btn-xs">
                                                                        Surat
                                                                    </a>
                                                                    <a href="{{ route('memoTidakRasmi', ['id' => $mohonan->permohonansID]) }}"
                                                                        class="btn btn-primary btn-xs">
                                                                        Memo
                                                                    </a>
                                                                </td>
                                                            @endif
                                                        @elseif($mohonan->statusPermohonan == 'Permohonan Gagal')
                                                            <td>
                                                                <span
                                                                    class="badge badge-danger">{{ $mohonan->statusPermohonan }}</span>
                                                            </td>
                                                            <td>
                                                                @if ($mohonan->JenisPermohonan == 'Rasmi')
                                                                    <a href="{{ route('suratRasmi', ['id' => $mohonan->permohonansID]) }}"
                                                                        class="btn btn-primary btn-xs">
                                                                        Surat
                                                                    </a>
                                                                    <a href="{{ route('memoRasmi', ['id' => $mohonan->permohonansID]) }}"
                                                                        class="btn btn-primary btn-xs">
                                                                        Memo
                                                                    </a>
                                                                @elseif($mohonan->JenisPermohonan == 'Tidak Rasmi')
                                                                    <a href="{{ route('suratTidakRasmi', ['id' => $mohonan->permohonansID]) }}"
                                                                        class="btn btn-primary btn-xs">
                                                                        Surat
                                                                    </a>
                                                                    <a href="{{ route('memoTidakRasmi', ['id' => $mohonan->permohonansID]) }}"
                                                                        class="btn btn-primary btn-xs">
                                                                        Memo
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        @elseif ($mohonan->statusPermohonan == 'Lulus Semakan BPSM')
                                                            <td><span class="badge badge-info">Disokong</span></td>
                                                        @endif

                                                        @if ($url != url('senaraiRekodIndividu'))
                                                            <td>
                                                                @if ($mohonan->statusPermohonan == 'Lulus Semakkan ketua Jabatan')
                                                                    <a href="{{ route('senaraiPending.hantar', ['id' => $mohonan->permohonansID]) }}"
                                                                        class="btn btn-success btn-xs"
                                                                        onclick="javascript: return confirm('Anda pasti untuk meluluskan Semakan permohonan ini?');"><i
                                                                            class="fa fa-check-square-o"> Terima</i></a>

                                                                    <a class="btn btn-danger btn-xs" data-toggle="modal"
                                                                        href='#mdl-tolak'
                                                                        data-id="{{ $mohonan->permohonansID }}"
                                                                        onclick="javascript: return confirm('Anda pasti untuk kembalikan semula permohonan ini?');"><i
                                                                            class="fa fa-times">Tolak</i></a>


                                                                @elseif($mohonan->statusPermohonan == 'Lulus Semakan BPSM')
                                                                @endif
                                                            </td>
                                                        @else
                                                        @endif
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div> --}}
                        <!-- ./box-body -->
                        <!-- /.box-footer -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm display">
                                            <thead>
                                                <tr class="text-center">
                                                    <th style="vertical-align: middle">No</th>
                                                    <th style="vertical-align: middle">Nama</th>
                                                    <th style="vertical-align: middle">Jabatan</th>
                                                    <th style="vertical-align: middle">Negara</th>
                                                    <th style="vertical-align: middle">Tarikh Permohonan</th>
                                                    <th style="vertical-align: middle">Tarikh Mula Perjalanan</th>
                                                    <th style="vertical-align: middle">Tarikh Kelulusan</th>
                                                    <th style="vertical-align: middle">Jenis Permohonan</th>
                                                    {{-- <th style="vertical-align: middle">No Rujukan</th> --}}
                                                    <th style="vertical-align: middle">Status Permohonan</th>
                                                    @if ($url != url('senaraiRekodIndividu'))
                                                        <th style="vertical-align: middle">Tindakan</th>
                                                    @else
                                                        <th style="vertical-align: middle">Dokumen(Cetak)</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($permohonan2 as $index => $mohonan)
                                                    <tr class="text-center">
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            <a
                                                                href="{{ url('detailPermohonan', [$mohonan->permohonansID]) }}">{{ $mohonan->nama }}</a>
                                                        </td>
                                                        <td>{{ $mohonan->kod_jabatan }}</td>
                                                        <td>
                                                            {{ $mohonan->negara }}@if ($mohonan->negara_lebih_dari_satu == 1){{ ', '.$mohonan->negara_tambahan }}
                                                            @endif
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($mohonan->tarikh_permohonan)->format('d/m/Y') }}
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($mohonan->tarikhMulaPerjalanan)->format('d/m/Y') }}
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($mohonan->tarikh_kelulusan)->format('d/m/Y') }}
                                                        </td>
                                                        <td>
                                                            {{ $mohonan->JenisPermohonan }}
                                                            {{-- <button type="button" class="btn btn-danger btn-xs" data-id="{{ $mohonan->id_kelulusan }}"
                                                                data-toggle="modal" data-target="#ubahstatuskelulusan" data-dismiss="modal">
                                                                    Tukar Status Kelulusan
                                                                </button> --}}

                                                        </td>
                                                        {{-- <td>SUK.D.200 (06) 455/16
                                                            ELN.JLD.{{ $mohonan->no_ruj_file }}({{ $mohonan->no_ruj_bil }})
                                                        </td> --}}
                                                        @if ($mohonan->status_kelulusan == 'Berjaya')
                                                            <td>
                                                                <span type="button"
                                                                    data-id="{{ $mohonan->id_kelulusan }}"
                                                                    data-toggle="modal" data-target="#ubahstatuskelulusan"
                                                                    data-dismiss="modal"
                                                                    class="badge badge-success">{{ $mohonan->status_kelulusan }}</span>
                                                                @if ($mohonan->pengesahan_pembatalan == 1)
                                                                    {{-- <span class="badge badge-info">Dibatalkan oleh Pemohon</span> --}}
                                                                    <button type="button" class="btn btn-primary btn-xs"
                                                                        data-toggle="modal"
                                                                        data-sebab="{{ $mohonan->sebab_pembatalan }}"
                                                                        data-tarikh="{{ \Carbon\Carbon::parse($mohonan->tarikh_batal)->format('d-m-Y') }}"
                                                                        data-target="#detailbatal">
                                                                        <i class="fa fa-info-circle"></i> Dibatalkan
                                                                    </button>
                                                                @endif
                                                            </td>

                                                            @if ($mohonan->JenisPermohonan == 'Rasmi')
                                                                <td class="text-center">
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
                                                                </td>
                                                            @elseif($mohonan->JenisPermohonan == 'Tidak Rasmi')
                                                                <td class="text-center">
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
                                                                </td>
                                                            @endif
                                                        @elseif($mohonan->status_kelulusan == 'Gagal')
                                                            <td>
                                                                <span class="badge badge-danger" type="button"
                                                                    data-id="{{ $mohonan->id_kelulusan }}"
                                                                    data-toggle="modal" data-target="#ubahstatuskelulusan"
                                                                    data-dismiss="modal">{{ $mohonan->status_kelulusan }}</span>
                                                            </td>
                                                            <td>
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
                                                                @endif
                                                            </td>
                                                        @elseif ($mohonan->statusPermohonan == 'Lulus Semakan BPSM')
                                                            <td><span class="badge badge-info">Disokong</span></td>
                                                        @endif

                                                        @if ($url != url('senaraiRekodIndividu'))
                                                            <td>
                                                                @if ($mohonan->statusPermohonan == 'Lulus Semakkan ketua Jabatan')
                                                                    <a href="{{ route('senaraiPending.hantar', ['id' => $mohonan->permohonansID]) }}"
                                                                        class="btn btn-success btn-xs"
                                                                        onclick="javascript: return confirm('Anda pasti untuk meluluskan Semakan permohonan ini?');"><i
                                                                            class="fa fa-check-square-o"> Terima</i></a>

                                                                    <a class="btn btn-danger btn-xs" data-toggle="modal"
                                                                        href='#mdl-tolak'
                                                                        data-id="{{ $mohonan->permohonansID }}"
                                                                        onclick="javascript: return confirm('Anda pasti untuk kembalikan semula permohonan ini?');"><i
                                                                            class="fa fa-times">Tolak</i></a>
                                                                @elseif($mohonan->statusPermohonan == 'Lulus Semakan BPSM')
                                                                @endif
                                                            </td>
                                                        @else
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
        </div>

        <div class="modal fade" id="mdl-tolak">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Sebab Ditolak</h4>
                    </div>
                    {!! Form::open(['method' => 'POST', 'url' => '/sebab']) !!}
                    <div class="modal-body">
                        <div class="form-group{{ $errors->has('sebb') ? ' has-error' : '' }}">
                            {!! Form::label('sebb', 'Sebab') !!}
                            {!! Form::text('sebb', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('sebb') }}</small>
                        </div>
                        {!! Form::hidden('id_edit', 'value', ['id' => 'id_edit']) !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Hantar</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>

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
                            <textarea style="resize: none" class="form-control" name="sebab" disabled id="sebab"
                                rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @if (Auth::user()->role == 'DatoSUK')
    <!-- Modal Tukar Kelulusan-->
    <div class="modal fade" id="ubahstatuskelulusan" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tukar Status Kelulusan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('tukarstatuskelulusan') }}" method="GET" id="ajax_tukar_status"
                    name="ajax_tukar_status">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="container-fluid">
                            <input type="hidden" value="" name="id" id="id">
                            Adakah pasti untuk menukar status permohonan ini?
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Kemaskini</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

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

        $('#ubahstatuskelulusan').on('show.bs.modal', event => {
            var button = $(event.relatedTarget);
            var modal = $(this);
            var id = button.data('id');
            // Use above variables to manipulate the DOM
            $(".modal-body #id").val(id);
        });

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
