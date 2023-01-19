@extends('layouts.eln')

@section('title', 'Senarai Gred Kod')

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
                <div class="col-md-12"><br>
                    @include('flash::message')
                    <br>
                    <div class="card">
                        <div class="card-header with-border">
                            <h3 class="card-title">Senarai Gred Kod </h3>
                            <div class="card-tools pull-right">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#tambahkodgred">
                                    <i class="fa fa-plus"></i> Tambah Kod gred
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <br>
                                    <table class="table table-bordered table-striped display2">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Gred Kod</th>
                                                <th>Gred Kod Klasifikasi</th>
                                                <th>Tindakan</th>
                                                {{-- <th>Tindakkan</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($kod as $kods)
                                                <tr>
                                                    <td><?php echo $i;
                                                    $i = $i + 1; ?></td>
                                                    <td>{{ $kods->gred_kod_abjad }}</td>
                                                    <td>{{ $kods->gred_kod_klasifikasi }}</td>
                                                    <td class="text-center">
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-primary btn-xs"
                                                            data-toggle="modal" data-id="{{ $kods->gred_kod_ID }}"
                                                            data-gred_kod_abjad="{{ $kods->gred_kod_abjad }}"
                                                            data-gred_kod_klasifikasi="{{ $kods->gred_kod_klasifikasi }}"
                                                            data-target="#kemaskinikodgred">
                                                            <i class="far fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-xs"
                                                            data-toggle="modal" data-id="{{ $kods->gred_kod_ID }}"
                                                            data-target="#padamkodgred">
                                                            <i class="far fa-trash-alt"></i>
                                                        </button>
                                                    </td>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <!-- /.row -->
                        </div>
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
        </div>
        </div>
    </section>
    <div class="modal fade" id="tambahkodgred" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kod Gred</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        {!! Form::open(['method' => 'POST', 'url' => 'prosesTambahGredKod']) !!}
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Gred Kod</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="kod" name="kod" required placeholder="N">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Gred Kod Klasifikasi</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="klasifikasi" name="klasifikasi" required
                                    placeholder="Teknologi Maklumat">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Daftar</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <!-- Modal Kemaskini-->
    <div class="modal fade" id="kemaskinikodgred" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kemaskini Kod Gred</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('kemaskini-kodgred') }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="container-fluid">
                            <input type="hidden" id="id" name="id" value="">
                            <div class="form-group">
                                <label for="gred_kod_abjad">Kod</label>
                                <input type="text" class="form-control" name="gred_kod_abjad" id="gred_kod_abjad" required
                                    placeholder="N" value="">
                            </div>
                            <div class="form-group">
                                <label for="gred_kod_klasifikasi">Klasifikasi</label>
                                <input type="text" class="form-control" name="gred_kod_klasifikasi"
                                    id="gred_kod_klasifikasi" placeholder="Pegawai Tadbir" required value="">
                            </div>
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

    <!-- Modal padam-->
    <div class="modal fade" id="padamkodgred" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Padam Kod Gred</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('padam-kodgred') }}" method="get">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="container-fluid">
                            <input type="hidden" id="id" name="id" value="">
                            Adakah anda pasti untuk padam kod gred ini?
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Padam</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
        $('#kemaskinikodgred').on('show.bs.modal', event => {
            var button = $(event.relatedTarget);
            var modal = $(this);
            var id = button.data('id');
            var gred_kod_abjad = button.data('gred_kod_abjad');
            var gred_kod_klasifikasi = button.data('gred_kod_klasifikasi');
            // Use above variables to manipulate the DOM

            $(".modal-body #id").val(id);
            $(".modal-body #gred_kod_klasifikasi").val(gred_kod_klasifikasi);
            $(".modal-body #gred_kod_abjad").val(gred_kod_abjad);
        });

        $('#padamkodgred').on('show.bs.modal', event => {
            var button = $(event.relatedTarget);
            var modal = $(this);
            var id = button.data('id');
            // Use above variables to manipulate the DOM

            $(".modal-body #id").val(id);
        });

        $(document).ready(function() {
            $('table.display2').DataTable({
                "pageLength": 10,
                "lengthMenu": [10, 30, 50, 100],
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
