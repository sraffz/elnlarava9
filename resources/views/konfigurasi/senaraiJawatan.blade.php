@extends('layouts.eln')

@section('title', 'Senarai Jawatan')

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
                            <h3 class="card-title">Senarai Jawatan </h3>
                            <div class="card-tools pull-right">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#tambahjawatan">
                                    <i class="fa fa-plus"></i> Tambah Jawatan
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-striped display2">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Jawatan</th>
                                                <th>Tindakan</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($jawatan as $jawatans)
                                                <tr>
                                                    <td><?php echo $i;
                                                    $i = $i + 1; ?></td>
                                                    <td>{{ $jawatans->namaJawatan }}</td>
                                                    <td class="text-center">
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-primary btn-xs"
                                                            data-toggle="modal" data-id="{{ $jawatans->idJawatan }}"
                                                            data-jawatan="{{ $jawatans->namaJawatan }}"
                                                            data-target="#kemaskinijawatan">
                                                            <i class="far fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-xs"
                                                            data-toggle="modal" data-id="{{ $jawatans->idJawatan }}"
                                                            data-target="#padamjawatan">
                                                            <i class="far fa-trash-alt"></i>
                                                        </button>
                                                    </td>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="tambahjawatan" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jawatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        {!! Form::open(['method' => 'POST', 'url' => 'prosesTambahJaw']) !!}
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="POST">
                        <label>Nama Jawatan</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="namajawatan" name="namajawatan" required
                                placeholder="Pegawai Tadbir">
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
    <div class="modal fade" id="kemaskinijawatan" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kemaskini Jawatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('kemaskini-jawatan') }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="container-fluid">
                            <input type="hidden" id="id" name="id" value="">
                            <div class="form-group">
                                <label for="namaJawatan">Nama Jawatan</label>
                                <input type="text" class="form-control" name="namaJawatan" id="namaJawatan" required
                                    placeholder="Pejabat Setiausaha Kerjaana" value="">
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
    <div class="modal fade" id="padamjawatan" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Padam Jawatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('padam-jawatan') }}" method="get">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="container-fluid">
                            <input type="hidden" id="id" name="id" value="">
                            Adakah anda pasti untuk padam jawatan ini?
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
        $('#kemaskinijawatan').on('show.bs.modal', event => {
            var button = $(event.relatedTarget);
            var modal = $(this);
            var id = button.data('id');
            var namaJawatan = button.data('jawatan');
            // Use above variables to manipulate the DOM

            $(".modal-body #id").val(id);
            $(".modal-body #namaJawatan").val(namaJawatan);
        });

        $('#padamjawatan').on('show.bs.modal', event => {
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
