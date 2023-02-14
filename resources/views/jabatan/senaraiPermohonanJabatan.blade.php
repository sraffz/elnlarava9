@extends('layouts.eln')

@section('title', 'Senarai Permohonan baru')

@section('link')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
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
                        <div class="card-header with-border">
                            <h3 class="card-title">Senarai Permohonan Baru (Individu){{-- <br><small>Tidak termasuk individu yg mengikut rombongan</small> --}} </h3>
                            <div class="float-right">
                                <a class="btn btn-dark btn-sm" href="{{ url('cetak-senarai-permohonan') }}"
                                    role="button">Cetak</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped display2">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Tarikh Permohonan</th>
                                            <th>Negara</th>
                                            <th>Tarikh Mula Perjalanan</th>
                                            <th>Jenis Permohonan</th>
                                            <th>Status Permohonan</th>
                                            <th>Tindakan & Dokumen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permohonan as $index => $mohonan)
                                            @php
                                                $id = Hashids::encode($mohonan->permohonansID);
                                            @endphp
                                            <tr class="text-center">
                                                <td>{{ $index + 1 }}</td>
                                                <td style="text-transform: capitalize">
                                                    {{-- @if ($mohonan->JenisPermohonan == 'rombongan') --}}
                                                    {{-- <a href="{{ url('detailPermohonanRombongan', [$mohonan->rombongans_id]) }}">{{ $mohonan->nama }}</a> --}}
                                                    {{-- @else --}}
                                                    <a href="{{ url('detailPermohonan', [$id]) }}">{{ $mohonan->nama }}</a>
                                                    {{-- @endif --}}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($mohonan->tarikhmohon)->format('d/m/Y') }}
                                                </td>
                                                <td>
                                                    {{ $mohonan->negara }}
                                                    @if ($mohonan->negara_tambahan != '')
                                                        {{ ', ' . $mohonan->negara_tambahan }}
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($mohonan->tarikhMulaPerjalanan)->format('d/m/Y') }}
                                                </td>
                                                <td style="text-transform: capitalize">{{ $mohonan->JenisPermohonan }}</td>
                                                <td>{{ $mohonan->statusPermohonan }}</td>
                                                <td>

                                                    @if ($mohonan->statusPermohonan == 'Ketua Jabatan')
                                                        <a onClick="setUserData({{ $id }});" data-toggle="modal"
                                                            data-target="#terimapermohonan"
                                                            class="btn btn-success btn-xs"><i class="fa fa-thumbs-up"></i>
                                                        </a>
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-danger btn-xs"
                                                            data-toggle="modal" data-id="{{ $id }}"
                                                            data-target="#tolakpermohonan">
                                                            <i class="fa fa-thumbs-down"></i>
                                                        </button>

                                                        <a href="{{ url('cetak-butiran-permohonan', [$mohonan->permohonansID]) }}"
                                                            class="btn btn-dark btn-xs">
                                                            <i class="fa fa-print"></i>
                                                        </a>
                                                        <hr class="mt-1 mb-1">
                                                        @if ($mohonan->JenisPermohonan == 'Rasmi')
                                                            Rasmi :
                                                            @foreach ($dokumen as $doc)
                                                                @if ($mohonan->permohonansID == $doc->permohonansID)
                                                                    <a class="btn btn-xs btn-primary"
                                                                        href="{{ route('detailPermohonanDokumen.download', ['id' => $doc->dokumens_id]) }}"
                                                                        target="blank"><i class="far fa-file-alt"></i></a>
                                                                @endif
                                                            @endforeach
                                                        @elseif ($mohonan->JenisPermohonan == 'Tidak Rasmi')
                                                            {{-- {{ $mohonan->pathFileCuti }} --}}Tidak Rasmi :
                                                            <a class="btn btn-xs btn-info"
                                                                href="{{ route('detailPermohonan.download', ['id' => $mohonan->permohonansID]) }}"
                                                                target="blank"><i class="far fa-file-alt"></i></a>
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

                                                    @elseif($mohonan->statusPermohonan == 'Permohonan Gagal')
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="terimapermohonan" tabindex="-1" role="dialog" aria-labelledby="favoritesModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="favoritesModalLabel">Sokong Permohonan</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                    <form method="GET" action="{{ url('pengesahan-permohonan') }}">
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="ulasan">Catatan (Jika perlu).</label>
                                <textarea name="ulasan" class="form-control"></textarea>
                                <input name="kopeID" id="kopeID" type="hidden" value="">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary" value="Hantar" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal Tolak permohonan-->
        <div class="modal fade" id="tolakpermohonan" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tolak Permohonan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="GET" action="{{ url('pengesahan-permohonan-tolak') }}">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="form-group">
                                    <input name="id" id="id" type="hidden" value="">
                                    <label for="ulasan">Catatan</label>
                                    <textarea name="ulasan" required="required" class="form-control"></textarea>
                                </div>
                                {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button> --}}
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-danger">Tolak Permohonan</button>
                            <button type="submit" class="btn btn-danger">Tolak Permohonan</button>
                        </div>
                    </form>
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
        $('#tolakpermohonan').on('show.bs.modal', event => {
            var button = $(event.relatedTarget);
            var modal = $(this);
            var id = button.data('id');
            // Use above variables to manipulate the DOM
            $(".modal-body #id").val(id);
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

    <script language="javascript">
        function setUserData(id) {
            var userHidden = document.getElementById('kopeID');
            userHidden.value = id;
        }
    </script>
@endsection
