@extends('layouts.eln')

@section('title', 'Maklumat Surat')

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
                    <div class="col-12">
                        <div class="card card-success card-tabs">
                            <div class="card-header p-0 pt-1">
                                <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                                    <li class="pt-2 px-3">
                                        <h3 class="card-title">Maklumat Surat</h3>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill"
                                            href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home"
                                            aria-selected="true">Tema Dan Cogan Kata</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill"
                                            href="#custom-tabs-two-profile" role="tab"
                                            aria-controls="custom-tabs-two-profile" aria-selected="false">Penolong Pengarah
                                            (Perkhidmatan)</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-two-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-two-home" role="tabpanel"
                                        aria-labelledby="custom-tabs-two-home-tab">
                                        {!! Form::open(['method' => 'POST', 'url' => 'prosesTambahCoganKata']) !!}
                                        {{ csrf_field() }}
                                        <input type="hidden" id="id" name="id" value="1">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="kata" name="kata" required
                                                    placeholder="COGAN KATA 1" value="{{ $cogankata->maklumat1 }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="kata" name="kata2"
                                                    placeholder="COGAN KATA 2" value="{{ $cogankata->maklumat2 }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="kata" name="kata3"
                                                    placeholder="COGAN KATA 3" value="{{ $cogankata->maklumat3 }}">
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            {!! Form::submit('Kemaskini', ['class' => 'btn btn-success']) !!}
                                        </div>
                                        {!! Form::close() !!}
                                        <br>
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr bgcolor="#7abcb9">
                                                    <th>Tema dan Cogan Kata</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ $cogankata->maklumat1 }}</td>
                                                </tr>
                                                <tr>
                                                @if ($cogankata->maklumat2 != null)
                                                    <td>{{ $cogankata->maklumat2 }}</td>
                                                </tr>
                                                @endif
                                                @if ($cogankata->maklumat3 != null)
                                                <tr>
                                                    <td>{{ $cogankata->maklumat3 }}</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel"
                                        aria-labelledby="custom-tabs-two-profile-tab">
                                        {!! Form::open(['method' => 'POST', 'url' => 'prosesTambahNamaPenolongPengarah']) !!}
                                        {{ csrf_field() }}
                                        <input type="hidden" id="pp" name="pp" value="Penolong Pengarah">
                                        <div class="form-group">
                                            <input type="text" name="maklumat1" id="maklumat1" class="form-control"
                                                value="{{ $penolongPengarah->maklumat1 }}" placeholder="Nama Pegawai">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="maklumat2" id="maklumat2" class="form-control"
                                                value="{{ $penolongPengarah->maklumat2 }}" placeholder="Jawatan">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="maklumat3" id="maklumat3" class="form-control"
                                                value="{{ $penolongPengarah->maklumat3 }}"
                                                placeholder="b.p:SETIAUSAHA KERAJAAN">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="maklumat4" id="maklumat4" class="form-control"
                                                value="{{ $penolongPengarah->maklumat4 }}" placeholder="NEGERI KELANTAN">
                                        </div>
                                        <div class="text-center">
                                            {!! Form::submit('Kemaskini', ['class' => 'btn btn-success']) !!}
                                        </div>
                                        {!! Form::close() !!}
                                        <br>
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr bgcolor="#7abcb9">
                                                    <th>Penolong Pengarah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (is_null($penolongPengarah))
                                                    <tr>
                                                        <td>
                                                            tiada
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td>{{ $penolongPengarah->maklumat1 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $penolongPengarah->maklumat2 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $penolongPengarah->maklumat3 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $penolongPengarah->maklumat4 }}</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    {{-- <div class="card">
                        <div class="card-header with-border">
                            <h3 class="card-title">Maklumat Surat</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="nav-tabs-custom">
                                                <ul class="nav nav-tabs">
                                                    <li class="active"><a href="#tab_1" data-toggle="tab">Tema dan
                                                            Cogan
                                                            Kata</a></li>
                                                    <li><a href="#tab_2" data-toggle="tab">Penolong
                                                            Pegarah(Perkhidmatan)</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="tab_1">
                                                        {!! Form::open(['method' => 'POST', 'url' => 'prosesTambahCoganKata']) !!}
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" name="_method" value="POST">

                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="kata" name="kata"
                                                                required
                                                                placeholder="RAJA BERDAULAT, RAKYAT MUAFAKAT, NEGERI BERKAT">
                                                            <input type="hidden" id="cogan" name="cogan" value="Cogan Kata">
                                                        </div>
                                                        <br>
                                                        <div class="btn-group pull-left">
                                                            {!! Form::submit('Kemaskini', ['class' => 'btn btn-success']) !!}
                                                        </div>
                                                        {!! Form::close() !!}
                                                        <br>
                                                        <table class="table table-bordered table-striped display2">
                                                            <thead>
                                                                <tr bgcolor="#7abcb9">
                                                                    <th>Tema dan Cogan Kata</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>{{ $cogankata->maklumat1 }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div> 
                                                    <div class="tab-pane" id="tab_2">
                                                        {!! Form::open(['method' => 'POST', 'url' => 'prosesTambahNamaPenolongPengarah']) !!}
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" name="_method" value="POST">

                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-book"></i>
                                                            </div>
                                                            <input type="text" class="form-control" id="maklumat1"
                                                                name="maklumat1"
                                                                value="{{ $penolongPengarah->maklumat1 }}" required
                                                                placeholder="Nama Penolong Pengarah">
                                                            <input type="text" class="form-control" id="maklumat2"
                                                                name="maklumat2"
                                                                value="{{ $penolongPengarah->maklumat2 }}" required
                                                                placeholder="Penolong Pengarah (Perkhimatan)">
                                                            <input type="text" class="form-control" id="maklumat3"
                                                                name="maklumat3"
                                                                value="{{ $penolongPengarah->maklumat3 }}"
                                                                placeholder="b.p:SETIAUSAHA KERAJAAN">
                                                            <input type="text" class="form-control" id="maklumat4"
                                                                name="maklumat4"
                                                                value="{{ $penolongPengarah->maklumat4 }}"
                                                                placeholder="NEGERI KELANTAN">
                                                            <input type="hidden" id="pp" name="pp"
                                                                value="Penolong Pengarah">
                                                        </div>
                                                        <br>
                                                        <div class="btn-group pull-left">
                                                            {!! Form::submit('Kemaskini', ['class' => 'btn btn-success']) !!}
                                                        </div>
                                                        {!! Form::close() !!}
                                                        <br>
                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr bgcolor="#7abcb9">
                                                                    <th>Penolong Pengarah</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if (is_null($penolongPengarah))
                                                                    <tr>
                                                                        <td>
                                                                            tiada
                                                                        </td>
                                                                    </tr>
                                                                @else
                                                                    <tr>
                                                                        <td>{{ $penolongPengarah->maklumat1 }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>{{ $penolongPengarah->maklumat2 }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>{{ $penolongPengarah->maklumat3 }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>{{ $penolongPengarah->maklumat4 }}</td>
                                                                    </tr>
                                                                @endif
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
                    </div> --}}
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
