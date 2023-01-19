@extends('layouts.eln')

@section('title', 'Senarai Permohonan')

@section('link')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('adminlte-3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <br>
                    @include('flash::message')
                    <br>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Senarai Permohonan Individu</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm display2">
                                            <thead>
                                                <tr>
                                                    <th style="vertical-align: middle;">No</th>
                                                    <th style="vertical-align: middle;">Nama</th>
                                                    <th style="vertical-align: middle;">Tarikh Permohonan</th>
                                                    <th style="vertical-align: middle;">Negara</th>
                                                    <th style="vertical-align: middle;">Tarikh Mula Perjalanan</th>
                                                    <th style="vertical-align: middle;">Jenis Permohonan</th>
                                                    <th style="vertical-align: middle;">Status Permohonan</th>
                                                    <th style="vertical-align: middle;">Surat Kelulusan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($permohonan as $index => $mohonan)
                                                    <tr class="text-center">
                                                        <td> {{ $index + 1 }} </td>
                                                        <td style="text-transform: capitalize">
                                                            {{-- @if ($mohonan->JenisPermohonan == 'rombongan')
                                                                <a
                                                                    href="{{ url('detailPermohonanRombongan', [$mohonan->rombongans_id]) }}">{{ $mohonan->nama }}</a>
                                                            @else --}}
                                                                <a
                                                                    href="{{ url('detailPermohonan', [$mohonan->permohonansID]) }}">{{ $mohonan->nama }}</a>
                                                            {{-- @endif --}}
                                                        </td>
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($mohonan->tarikhmohon)->format('d/m/Y') }}
                                                        </td>
                                                        <td>{{ $mohonan->negara }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($mohonan->tarikhMulaPerjalanan)->format('d/m/Y') }}
                                                        </td>
                                                        {{-- <td>{{\Carbon\Carbon::parse($mohonan->tarikhAkhirPerjalanan)->format('d/m/Y')}}</td> --}}
                                                        <td style="text-transform: capitalize">
                                                            {{ $mohonan->JenisPermohonan }}</td>
                                                        <td>
                                                            @if ($mohonan->statusPermohonan == 'Lulus Semakkan ketua Jabatan')
                                                                <span class="badge badge-warning">Dalam Tindakkan
                                                                    BPSM</span>
                                                            @elseif($mohonan->statusPermohonan == 'Ketua Jabatan')
                                                                <span class="badge badge-warning">Dalam Tindakkan Ketua
                                                                    Jabatan</span>
                                                            @elseif($mohonan->statusPermohonan == 'Lulus Semakan BPSM')
                                                                <span class="badge badge-primary">Disokong</span>
                                                            @elseif($mohonan->statusPermohonan == 'Permohonan Berjaya')
                                                                
                                                                   @if ($mohonan->status_rombongan == 'Gagal')
                                                                   <span class="badge badge-danger">{{ $mohonan->status_rombongan }}</span>
                                                                   @else
                                                                   <span class="badge badge-success">Berjaya</span>
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
                                                                   @endif     

                                                            @elseif($mohonan->statusPermohonan == 'Permohonan Gagal')
                                                                <span class="badge badge-danger">Gagal</span>
                                                            @else
                                                                <span class="badge badge-danger">{{ $mohonan->statusPermohonan }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($mohonan->statusPermohonan == 'Permohonan Berjaya')
                                                                @if ($mohonan->JenisPermohonan == 'Rasmi')
                                                                    @if ($jabatan->surat == 'MEMO')
                                                                        <a href="{{ route('memoRasmi', ['id' => $mohonan->permohonansID]) }}"
                                                                            class="btn btn-primary btn-xs">
                                                                            Memo
                                                                        </a>
                                                                    @elseif ($jabatan->surat == 'SURAT')
                                                                        <a href="{{ route('suratRasmi', ['id' => $mohonan->permohonansID]) }}"
                                                                            class="btn btn-primary btn-xs">
                                                                            Surat
                                                                        </a>
                                                                    @endif
                                                                    <div class="mt-2">
                                                                    </div>
                                                                @elseif($mohonan->JenisPermohonan == 'Tidak Rasmi')
                                                                    @if ($jabatan->surat == 'MEMO')
                                                                        <a href="{{ route('memoTidakRasmi', ['id' => $mohonan->permohonansID]) }}"
                                                                            class="btn btn-primary btn-xs">
                                                                            Memo
                                                                        </a>
                                                                    @elseif ($jabatan->surat == 'SURAT')
                                                                        <a href="{{ route('suratTidakRasmi', ['id' => $mohonan->permohonansID]) }}"
                                                                            class="btn btn-primary btn-xs">
                                                                            Surat
                                                                        </a>
                                                                    @endif
                                                                    <div class="mt-2">
                                                                    </div>
                                                                @endif
                                                                @if (Auth::user()->role == 'pengguna')
                                                                    @if ($mohonan->pengesahan_pembatalan == 1)
                                                                        <button type="button" class="btn btn-info btn-xs"
                                                                            data-toggle="modal"
                                                                            data-sebab="{{ $mohonan->sebab_pembatalan }}"
                                                                            data-tarikh="{{ \Carbon\Carbon::parse($mohonan->tarikh_batal)->format('d-m-Y') }}"
                                                                            data-target="#detailbatal">
                                                                            <i class="fa fa-info-circle"></i> Sebab Batal
                                                                        </button>
                                                                    @else
                                                                        <button type="button" class="btn btn-dark btn-xs"
                                                                            data-toggle="modal"
                                                                            data-id="{{ $mohonan->permohonansID }}"
                                                                            data-target="#batalpermohonan">
                                                                            Batal Permohonan
                                                                        </button>
                                                                    @endif
                                                                @endif
                                                            @elseif($mohonan->statusPermohonan == 'Permohonan Gagal')
                                                                @if ($mohonan->JenisPermohonan == 'Rasmi')
                                                                    @if ($jabatan->surat == 'MEMO')
                                                                        <a href="{{ route('memoRasmi', ['id' => $mohonan->permohonansID]) }}"
                                                                            class="btn btn-primary btn-xs">
                                                                            Memo
                                                                        </a>
                                                                    @elseif ($jabatan->surat == 'SURAT')
                                                                        <a href="{{ route('suratRasmi', ['id' => $mohonan->permohonansID]) }}"
                                                                            class="btn btn-primary btn-xs">
                                                                            Surat
                                                                        </a>
                                                                    @endif
                                                                    <div class="mt-2"></div>
                                                                @elseif($mohonan->JenisPermohonan == 'Tidak Rasmi')
                                                                    @if ($jabatan->surat == 'MEMO')
                                                                        <a href="{{ route('memoTidakRasmi', ['id' => $mohonan->permohonansID]) }}"
                                                                            class="btn btn-primary btn-xs">
                                                                            Memo
                                                                        </a>
                                                                        <div class="mt-2"></div>
                                                                    @elseif ($jabatan->surat == 'SURAT')
                                                                        <a href="{{ route('suratTidakRasmi', ['id' => $mohonan->permohonansID]) }}"
                                                                            class="btn btn-primary btn-xs">
                                                                            Surat
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        </td>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.chart-responsive -->
                                </div>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Senarai Permohonan Rombongan</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm display2">
                                            <thead>
                                                <tr>
                                                    <th style="vertical-align: middle;">No</th>
                                                    <th style="vertical-align: middle;">Nama</th>
                                                    <th style="vertical-align: middle;">Tarikh Permohonan</th>
                                                    <th style="vertical-align: middle;">Negara</th>
                                                    <th style="vertical-align: middle;">Tarikh Mula Perjalanan</th>
                                                    {{-- <th style="vertical-align: middle;">Jenis Permohonan</th> --}}
                                                    <th style="vertical-align: middle;">Status Permohonan</th>
                                                    <th style="vertical-align: middle;">Dokumen Kelulusan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($rombo as $index => $mohonan)
                                                    <tr class="text-center">
                                                        <td> {{ $index + 1 }} </td>
                                                        <td style="text-transform: capitalize">
                                                            {{-- @if ($mohonan->JenisPermohonan == 'rombongan')
                                                                <a
                                                                    href="{{ url('detailPermohonan', [$mohonan->permohonansID]) }}">{{ $mohonan->nama }}</a>
                                                            @else --}}
                                                            <a
                                                                href="{{ url('detailPermohonanRombongan', [$mohonan->rombongans_id]) }}">{{ $mohonan->nama }}</a>
                                                            {{-- @endif --}}
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($mohonan->tarikhMohon)->format('d/m/Y') }}
                                                        </td>
                                                        <td>{{ $mohonan->negaraRom }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($mohonan->tarikhMulaRom)->format('d/m/Y') }}
                                                        </td>
                                                        {{-- <td>{{\Carbon\Carbon::parse($mohonan->tarikhAkhirPerjalanan)->format('d/m/Y')}}</td> --}}
                                                        {{-- <td style="text-transform: capitalize">
                                                            {{ $mohonan->JenisPermohonan }}</td> --}}
                                                        <td>
                                                            @if ($mohonan->statusPermohonanRom == 'Lulus Semakkan ketua Jabatan')
                                                                <span class="badge badge-warning">Dalam Tindakkan
                                                                    BPSM</span>
                                                            @elseif($mohonan->statusPermohonanRom == 'Pending')
                                                                <span class="badge badge-warning">Dalam Tindakkan Ketua
                                                                    Jabatan</span>
                                                            @elseif($mohonan->statusPermohonanRom == 'Lulus Semakan BPSM')
                                                                <span class="badge badge-primary">Disokong Ketua
                                                                    Jabatan</span>
                                                            @elseif($mohonan->statusPermohonanRom == 'Permohonan Berjaya')
                                                                <span class="badge badge-success">Berjaya</span>
                                                            @elseif($mohonan->statusPermohonanRom == 'Permohonan Gagal')
                                                                <span class="badge badge-danger">Gagal</span>
                                                            @elseif($mohonan->statusPermohonanRom == 'Lulus Semakan')
                                                                <span class="badge badge-primary">Disokong</span>
                                                            @else
                                                                <span
                                                                    class="badge badge-danger">{{ $mohonan->statusPermohonanRom }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($mohonan->statusPermohonanRom == 'Permohonan Berjaya' || $mohonan->statusPermohonanRom == 'Permohonan Gagal')
                                                                @if ($mohonan->surat == 'MEMO')
                                                                    <a href="{{ route('memo-rombongan', ['id' => $mohonan->rombongans_id]) }}"
                                                                        class="btn btn-primary btn-xs">
                                                                        Memo
                                                                    </a>
                                                                @elseif ($mohonan->surat == 'SURAT')
                                                                    <a href="{{ route('surat-rombongan', ['id' => $mohonan->rombongans_id]) }}"
                                                                        class="btn btn-primary btn-xs">
                                                                        Surat
                                                                    </a>
                                                                @endif
                                                            @endif
                                                        </td>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.chart-responsive -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- ./box-body -->
                        <!-- /.box-footer -->
                    </div>
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
        <div class="modal fade" id="favoritesModal" tabindex="-1" role="dialog" aria-labelledby="favoritesModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="favoritesModalLabel">Ulasan</h4>
                    </div>

                    <div class="modal-body">
                        <form action="senaraiPermohonanJabatan/hantar">
                            <div class="modal-body">Sila masukkan ulasan.<br>
                                <textarea name="ulasan" required="required" class="form-control"></textarea>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="get">
                                <input name="kopeID" id="kopeID" type="hidden" value="">
                            </div>

                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" value="Hantar" />
                                {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button> --}}
                        </form>
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
        
        $(document).ready(function() {
            $('table.display2').DataTable({
                "pageLength": 5,
                "lengthMenu": [5, 10, 30, 50],
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
