@extends('layouts.eln')

@section('title', 'eluarNegara')

@section('link')

@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Butiran Permohonan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{ url('senaraiPermohonanProses', [Auth::user()->usersID]) }}">Senarai
                                Permohonan</a></li>
                        <li class="breadcrumb-item active">Butiran Permohonan</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('flash::message')
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Maklumat Rombongan</h3>
                        </div>
                        <!-- /.card-header -->
                        @foreach ($rombongan as $rombooo)
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""><i class="fab fa-codepen"></i> Kod Rombongan</label>
                                            <input type="text" class="form-control" disabled
                                                value="{{ $rombooo->codeRom }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""><i class="fas fa-question-circle"></i> Jenis Rombongan</label>
                                            <input type="text" class="form-control" disabled
                                                value="{{ $rombooo->jenis_rombongan }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for=""><i class="fas fa-globe"></i> Negara</label>
                                            <input type="text" class="form-control" disabled
                                                value="{{ $rombooo->negaraRom }}">
                                        </div>
                                        @if ($rombooo->negaraRom_lebih == 1)
                                        <div class="form-group">
                                            <label for=""><i class="fas fa-globe"></i> Lain-lain Negara</label>
                                            <input type="text" class="form-control" disabled
                                                value="{{ $rombooo->negaraRom_tambahan }}">
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for=""><i class="fas fa-map-marker-alt"></i> Alamat</label>
                                            <textarea class="form-control" disabled
                                                rows="3">{{ $rombooo->alamatRom }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tujuanRom"><i class="fas fa-keyboard"></i> Tujuan Rombongan</label>
                                            <input type="text" class="form-control" name="tujuanRom" id="tujuanRom"
                                                disabled value="{{ $rombooo->tujuanRom }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tujuanRom"><i class="fas fa-money-bill"></i> Jenis Kewangan
                                                Rombongan</label>
                                            <input type="text" class="form-control" name="tujuanRom" id="tujuanRom"
                                                disabled value="{{ $rombooo->jenisKewanganRom }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tujuanRom"><i class="fas fa-money-bill"></i> Anggaran
                                                Perbelanjaan</label>
                                            <input type="text" class="form-control" name="tujuanRom" id="tujuanRom"
                                                disabled value="{{ $rombooo->anggaranBelanja }}">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="mula"><i class="fa fa-calendar"></i> Mula Rombongan</label>
                                            <input id="mula" type="text" class="form-control"
                                                value="{{ \Carbon\Carbon::parse($rombooo->tarikhMulaRom)->format('d/m/Y') }}"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="akhir"><i class="fa fa-calendar"></i> Tamat Rombongan</label>
                                            <input id="akhir" type="text" class="form-control"
                                                value="{{ \Carbon\Carbon::parse($rombooo->tarikhAkhirRom)->format('d/m/Y') }}"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="jumlah"><i class="fa fa-calendar"></i> Tempoh Rombongan</label>
                                            <input id="jumlah" type="text" class="form-control"
                                                value="{{ $jumlahDate }} Hari" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="catatan">Catatan</label>
                                            <textarea style="resize: none" class="form-control" disabled
                                                disabled>{{ $rombooo->catatan_permohonan }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <strong><i class="fa fa-user-friends"></i> Senarai Peserta</strong>
                                <p class="text-muted" style="text-transform: uppercase">
                                <table class="table table-bordered table-sm ">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>BIL</th>
                                            <th>NAMA</th>
                                            <th colspan="2">TINDAKAN</th>
                                        </tr>
                                    </thead>
                                    <tbody class="peserta">
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($peserta as $peser)
                                            @if (Auth::user()->role == 'jabatan' || Auth::user()->role == 'DatoSUK')
                                                @if ($peser->statusPermohonan == 'Lulus Semakan BPSM' || $peser->statusPermohonan == 'Permohonan Berjaya' || $peser->statusPermohonan == 'Permohonan Gagal')
                                                    <tr>
                                                        <td scope="row" class="text-center">
                                                            {{ $i++ }}
                                                        </td>
                                                        <td style="text-transform: uppercase; width: 65%">
                                                            <a data-toggle="modal" href='#mdl-kemaskini'
                                                                data-nama="{{ $peser->user->nama }}"
                                                                data-nokp="{{ $peser->user->nokp }}"
                                                                data-email="{{ $peser->user->email }}"
                                                                data-jawatan="{{ $peser->user->jawatan }}"
                                                                data-jabatan="{{ $peser->nama_jabatan }}">
                                                                {{ $peser->user->nama }}</a>
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($peser->user->usersID == $rombooo->ketua_rombongan)
                                                                Ketua Rombongan
                                                            @else
                                                                @if (Auth::user()->role == 'jabatan' && $peser->status_pengesah == 'disokong')
                                                                @else
                                                                <button type="button" class="btn btn-primary btn-xs"
                                                                    data-toggle="modal"
                                                                    data-romboid="{{ $rombooo->rombongans_id }}"
                                                                    data-id="{{ $peser->user->usersID }}"
                                                                    data-target="#tukarkr">
                                                                    Lantik Ketua Rombongan
                                                                </button>
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if (Auth::user()->role == 'DatoSUK')
                                                                @if (!empty($peser->status_kelulusan))
                                                                    @if ($peser->status_kelulusan == 'Berjaya')
                                                                        <span
                                                                            class="badge badge-pill badge-success">{{ $peser->status_kelulusan }}</span>
                                                                        <!-- Button trigger modal -->
                                                                        <button type="button" class="btn btn-danger btn-xs"
                                                                            data-id="{{ $peser->id_pelulus }}"
                                                                            data-toggle="modal"
                                                                            data-target="#ubahstatuskelulusan">
                                                                            <i class="fas fa-exchange-alt"></i>
                                                                        </button>
                                                                    @else
                                                                        <span
                                                                            class="badge badge-pill badge-danger">{{ $peser->status_kelulusan }}</span>
                                                                        <button type="button" class="btn btn-success btn-xs"
                                                                            data-id="{{ $peser->id_pelulus }}"
                                                                            data-toggle="modal"
                                                                            data-target="#ubahstatuskelulusan">
                                                                            <i class="fas fa-exchange-alt"></i>
                                                                        </button>
                                                                    @endif
                                                                @else
                                                                    <a href="{{ route('senaraiPermohonan.tolakPermohonan', [$peser->permohonansID]) }}"
                                                                        class="btn btn-danger btn-xs"
                                                                        onclick="javascript: return confirm('Anda pasti untuk menolak permohonan peserta ini?');">
                                                                        <i class="far fa-thumbs-down"></i> Tolak
                                                                        Permohonan
                                                                    </a>
                                                                @endif
                                                            @elseif (Auth::user()->role == 'jabatan')
                                                                @if (!empty($peser->status_pengesah))
                                                                    @if ($peser->status_pengesah == 'disokong')
                                                                        <span
                                                                            class="badge badge-pill badge-success">{{ $peser->status_pengesah }}</span>
                                                                    @else
                                                                        <span
                                                                            class="badge badge-pill badge-danger">{{ $peser->status_pengesah }}</span>
                                                                    @endif
                                                                @else
                                                                    <button type="button" class="btn btn-danger btn-xs"
                                                                        data-toggle="modal"
                                                                        data-romboid="{{ $rombooo->rombongans_id }}"
                                                                        data-id="{{ $peser->permohonansID }}"
                                                                        data-target="#tolakpermohonan">
                                                                        <i class="fa fa-thumbs-down"> </i> Tolak
                                                                        Permohonan
                                                                    </button>
                                                                @endif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @else
                                                <tr>
                                                    <td scope="row" class="text-center">
                                                        {{ $i++ }}
                                                    </td>
                                                    <td style="text-transform: uppercase">
                                                        <a data-toggle="modal" href='#mdl-kemaskini'
                                                            data-nama="{{ $peser->user->nama }}"
                                                            data-nokp="{{ $peser->user->nokp }}"
                                                            data-email="{{ $peser->user->email }}"
                                                            data-jawatan="{{ $peser->user->jawatan }}"
                                                            data-jabatan="{{ $peser->nama_jabatan }}">
                                                            {{ $peser->user->nama }}
                                                        </a>
                                                        @if ($peser->user->usersID == $rombooo->ketua_rombongan)
                                                            <i> (Ketua Rombongan)</i>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <i>
                                                            @if ($peser->statusPermohonan == 'Ketua Jabatan')
                                                                (Perlu Sokongan Ketua Jabatan)
                                                            @elseif ($peser->statusPermohonan == 'Lulus Semakan BPSM')
                                                                (Disokong oleh ketua Jabatan)
                                                            @elseif ($peser->statusPermohonan == 'Permohonan Gagal')
                                                                (Permohonan ditolak)
                                                            @elseif ($peser->statusPermohonan == 'Permohonan Berjaya')
                                                                (Permohonan Diluluskan)
                                                            @endif
                                                        </i>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                </p>
                                @if ($rombooo->jenis_rombongan == 'Rasmi')
                                    <hr>
                                    <strong><i class="fa fa-file"></i> Dokumen Rasmi</strong>
                                    <div class="mt-2">
                                        <p class="text-muted">
                                            @if (is_null($dokumen))
                                                Tiada Dokumen
                                            @else
                                                <a class="btn btn-sm btn-info" href="{{ route('detailPermohonanDokumen.download', [$dokumen->dokumens_id]) }}"> Dokumen Rombongan                                            </a>
                                            @endif
                                        </p>
                                    </div>
                                @endif

                                <hr>
                                <p class="text-center">
                                    <a class="btn btn-danger" href="{{ URL::previous() }}" role="button">Kembali</a>
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="mdl-kemaskini">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Maklumat Pemohon</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                {!! Form::open(['method' => 'POST', 'url' => '#']) !!}
                <div class="modal-body">
                    <div class="form-group{{ $errors->has('nama_edit') ? ' has-error' : '' }}">
                        {!! Form::label('nama_edit', 'Nama') !!}
                        {!! Form::text('nama_edit', null, ['class' => 'form-control', 'disabled' => 'disabled', 'id' => 'nama_edit']) !!}
                        <small class="text-danger">{{ $errors->first('nama_edit') }}</small>
                    </div>
                    <div class="form-group{{ $errors->has('nokp_edit') ? ' has-error' : '' }}">
                        {!! Form::label('nokp_edit', 'Kad Pengenalan') !!}
                        {!! Form::text('nokp_edit', null, ['class' => 'form-control', 'disabled' => 'disabled', 'id' => 'nokp_edit']) !!}
                        <small class="text-danger">{{ $errors->first('nokp_edit') }}</small>
                    </div>
                    <div class="form-group{{ $errors->has('email_edit') ? ' has-error' : '' }}">
                        {!! Form::label('email_edit', 'Email') !!}
                        {!! Form::email('email_edit', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                        <small class="text-danger">{{ $errors->first('email_edit') }}</small>
                    </div>
                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <input type="text" class="form-control" name="jabatan" disabled id="jabatan_edit" value=""
                            placeholder="">
                    </div>
                    {{-- <div class="form-group">
                        <label for="jabatan">Jawatan</label>
                        <input type="text" class="form-control" name="jabatan" disabled id="jabatan_edit" value=""
                            placeholder="">
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Batal</button>
                    {{-- <button type="submit" class="btn btn-primary">Kemaskini</button> --}}
                </div>
                {!! Form::close() !!}
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
                                <input name="romboid" id="romboid" type="hidden" value="">
                                <label for="ulasan">Catatan</label>
                                <textarea name="ulasan" required="required" class="form-control"></textarea>
                            </div>
                            {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button> --}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Tolak Permohonan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tukar Ketua permohonan-->
    <div class="modal fade" id="tukarkr" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tolak Permohonan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="GET" name="ajax-contact-form" id="ajax-contact-form" action="javascript:void(0)">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="text-center">
                                Lantik peserta ini sebagai ketua rombongan?
                            </div>
                            <input name="id" id="id" type="hidden" value="">
                            <input name="romboid" id="romboid" type="hidden" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" id="submit" class="btn btn-success tukar_button">Lantik Ketua
                            Rombongan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                <form action="{{ url('tukarstatuskelulusan') }}" method="get">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="container-fluid">
                            <input type="hidden" value="" name="id" id="id">
                            Adakah pasti untuk menukar status permohonan peserta ini?
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
@endsection
@section('script')
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script>
        $(document).on('click', '.tukar_button', function(event) {
            event.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#submit').html('Sila Tunggu...');
            $("#submit").attr("disabled", true);
            $.ajax({
                url: "{{ url('tukar-ketua-rombongan') }}",
                type: "PUT",
                data: $('#ajax-contact-form').serialize(),
                dataType: 'json',
                success: function(response) {
                    $('#submit').html('Berjaya Ditukar');
                    $("#submit").attr("disabled", false);
                    $('#tukarkr').modal('hide');
                    setTimeout(location.reload.bind(location), 1500);
                    Swal.fire(
                    'Berjaya',
                    'Ketua Rombongan telah ditukar!',
                    'success'
                    );
                }
            });
        });


        $(document).on('click', 'tukar_button', function(e) {
            e.preventDefault();

        });


        $('#tolakpermohonan').on('show.bs.modal', event => {
            var button = $(event.relatedTarget);
            var modal = $(this);
            var id = button.data('id');
            var romboid = button.data('romboid');
            // Use above variables to manipulate the DOM
            $(".modal-body #id").val(id);
            $(".modal-body #romboid").val(romboid);
        });

        $('#ubahstatuskelulusan').on('show.bs.modal', event => {
            var button = $(event.relatedTarget);
            var modal = $(this);
            var id = button.data('id');
            // Use above variables to manipulate the DOM
            $(".modal-body #id").val(id);
        });

        $('#tukarkr').on('show.bs.modal', event => {
            var button = $(event.relatedTarget);
            var modal = $(this);
            var id = button.data('id');
            var romboid = button.data('romboid');
            // Use above variables to manipulate the DOM
            $(".modal-body #id").val(id);
            $(".modal-body #romboid").val(romboid);
        });

        $('#mdl-kemaskini').on('show.bs.modal', function(event) {

            var button = $(event.relatedTarget);
            var nama = button.data('nama');
            var nokp = button.data('nokp');
            var email = button.data('email');
            var jawatan = button.data('jawatan');
            var jabatan = button.data('jabatan');

            $('#nama_edit').val(nama);
            $('#nokp_edit').val(nokp);
            $('#email_edit').val(email);
            $('#jawatan_edit').val(jawatan);
            $('#jabatan_edit').val(jabatan);
        });
    </script>

@endsection
