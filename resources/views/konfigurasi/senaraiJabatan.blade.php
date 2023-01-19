@extends('layouts.eln')

@section('title', 'Senarai Jabatan')

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
                <div class="col-md-12"> <br>
                    @include('flash::message')
                    <div class="card">
                        <div class="card-header with-border">
                            <h3 class="card-title">Senarai Jabatan </h3>
                            <div class="float-right">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahjabatan">
                                    <i class="fa fa-plus"></i> Tambah Jabatan
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <br>
                                    <table class="table table-bordered table-striped display2">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Jabatan</th>
                                                <th>Alamat Jabatan</th>
                                                <th>Ketua Jabatan</th>
                                                <th>Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($jabatan as $jabatans)
                                                <tr>
                                                    <td><?php echo $i;
                                                    $i = $i + 1; ?></td>
                                                    <td>{{ $jabatans->nama_jabatan }} ({{ $jabatans->kod_jabatan }})</td>
                                                    <td>
                                                        @if ($jabatans->alamat != null)
                                                        {{ $jabatans->alamat }}, <br> 
                                                            
                                                        @endif
                                                        {{ $jabatans->poskod }} {{ $jabatans->daerah }},  <br> 
                                                        {{ $jabatans->negeri }} 
                                                    </td>
                                                    <td>{{ $jabatans->jawatan_ketua }}</td>
                                                    <td class="text-center">
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-primary btn-xs"
                                                            data-toggle="modal" data-id="{{ $jabatans->jabatan_id }}"
                                                            data-kod_jabatan="{{ $jabatans->kod_jabatan }}"
                                                            data-nama_jabatan="{{ $jabatans->nama_jabatan }}"
                                                            data-ketua="{{ $jabatans->jawatan_ketua }}"
                                                            data-alamat="{{ $jabatans->alamat }}"
                                                            data-poskod="{{ $jabatans->poskod }}"
                                                            data-daerah="{{ $jabatans->daerah }}"
                                                            data-negeri="{{ $jabatans->negeri }}"
                                                            data-surat="{{ $jabatans->surat }}"
                                                            data-target="#kemaskinijabatan">
                                                            <i class="far fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-xs"
                                                            data-toggle="modal" data-id="{{ $jabatans->jabatan_id }}"
                                                            data-target="#padamjabatan">
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

        <!-- Modal Tambah Jawatan-->
        <div class="modal fade" id="tambahjabatan" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Jabatan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('prosesTambahJab') }}" method="post" autocomplete="off">
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="ketua">Jawatan Ketua Jabatan/Agensi</label>
                                <input type="text" class="form-control form-control-sm" name="ketua" placeholder="Pengarah" required>
                            </div>
                            <div class="form-group">
                                <label for="kod_jabatan">Kod Jabatan</label>
                                <input type="text" class="form-control form-control-sm" name="kod_jabatan" placeholder="SUK" required>
                            </div>
                            <div class="form-group">
                                <label for="nama_jabatan">Nama Jabatan</label>
                                <input type="text" class="form-control form-control-sm" name="nama_jabatan" required placeholder="Pejabat Setiausaha Kerajaan">
                            </div>
                            <div class="form-group">
                              <label for="alamat">Alamat</label>
                              <textarea class="form-control" name="alamat" id="alamat" rows="3"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="poskod">Poskod</label>
                                        <input type="text" class="form-control form-control-sm" name="poskod" placeholder="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="daerah">Daerah</label>
                                        <input type="text" class="form-control form-control-sm" name="daerah" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                <div class="form-group">
                                    <label for="negeri">Negeri</label>
                                    <input type="text" class="form-control form-control-sm" name="negeri" value="Kelantan" required>
                                </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="surat">Surat</label>
                                        <select name="surat" id="surat" class="form-control form-control-sm">
                                            <option value="">Sila Pilih</option>
                                            <option value="SURAT">SURAT</option>
                                            <option value="MEMO">MEMO</option>
                                        </select>                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Kemaskini-->
        <div class="modal fade" id="kemaskinijabatan" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Kemaskini Jabatan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('kemaskini-jabatan') }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="container-fluid">
                                <input type="hidden" id="id" name="id" value="">
                                <div class="form-group">
                                    <label for="ketua">Jawatan Ketua Jabatan/Agensi</label>
                                    <input type="text" class="form-control form-control-sm" id="ketua" name="ketua" placeholder="Pengarah" value="" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama_jabatan">Nama Jabatan</label>
                                    <input type="text" class="form-control" name="nama_jabatan" id="nama_jabatan" required
                                        placeholder="Pejabat Setiausaha Kerjaana" value="">
                                </div>
                                <div class="form-group">
                                    <label for="kod_jabatan">Kod Jabatan</label>
                                    <input type="text" class="form-control" name="kod_jabatan" id="kod_jabatan"
                                        placeholder="SUK" required value="">
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control" name="alamat" id="alamat" rows="3"></textarea>
                                  </div>
                                  <div class="row">
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="poskod">Poskod</label>
                                              <input type="text" class="form-control form-control-sm" id="poskod" name="poskod" value="" required>
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="daerah">Daerah</label>
                                              <input type="text" class="form-control form-control-sm" id="daerah" name="daerah" value="" required>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-md-8">
                                      <div class="form-group">
                                          <label for="negeri">Negeri</label>
                                          <input type="text" class="form-control form-control-sm" id="negeri" name="negeri" value="" required>
                                      </div>
                                      </div>
                                      <div class="col-md-4">
                                          <div class="form-group">
                                              <label for="surat">Surat</label>
                                              <select name="surat" id="surat" class="form-control form-control-sm">
                                                  <option value="">Sila Pilih</option>
                                                  <option value="SURAT">SURAT</option>
                                                  <option value="MEMO">MEMO</option>
                                              </select>                                    
                                          </div>
                                      </div>
                                  </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="id" data-id="id" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Kemaskini</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal padam-->
        <div class="modal fade" id="padamjabatan" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Padam Jabatan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('padam-jabatan') }}" method="get">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="container-fluid">
                                <input type="hidden" id="id" name="id" value="">
                                Adakah anda pasti untuk padam Jabatan ini?
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
        $('#kemaskinijabatan').on('show.bs.modal', event => {
            var button = $(event.relatedTarget);
            var modal = $(this);
            var id = button.data('id');
            var nama_jabatan = button.data('nama_jabatan');
            var kod_jabatan = button.data('kod_jabatan');
            var ketua = button.data('ketua');
            var alamat = button.data('alamat');
            var poskod = button.data('poskod');
            var daerah = button.data('daerah');
            var negeri = button.data('negeri');
            var surat = button.data('surat');
            // Use above variables to manipulate the DOM

            $("#id").val(id);
            $(".modal-body #kod_jabatan").val(kod_jabatan);
            $("#nama_jabatan").val(nama_jabatan);
            $(".modal-body #ketua").val(ketua);
            $(".modal-body #alamat").val(alamat);
            $(".modal-body #poskod").val(poskod);
            $(".modal-body #daerah").val(daerah);
            $(".modal-body #negeri").val(negeri);
            $(".modal-body #surat").val(surat);
        });

        $('#padamjabatan').on('show.bs.modal', event => {
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

        $(':input').keyup(function(){
            var box = event.target;
            var txt = $(this).val();
            var stringStart = box.selectionStart;
            var stringEnd = box.selectionEnd;
            $(this).val(txt.replace(/^(.)|(\s|\-)(.)/g, function($word) {
                return $word.toUpperCase();
            }));
            box.setSelectionRange(stringStart , stringEnd);
        });
        // $(':input').keyup(function(){
        //     $(this).val($(this).val().toUpperCase());
        // });

    </script>
@endsection
