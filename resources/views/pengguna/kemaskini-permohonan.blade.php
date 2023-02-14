@extends('layouts.eln')

@section('title', 'Kemaskini Permohonan Rombongan')

@section('link')
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <link rel="stylesheet"
        href="{{ asset('adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- Select2 -->
    {{-- <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}"> --}}
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12"><br>
                    @include('flash::message')
                    <div class="card card-primary card-solid">
                        <div class="card-header with-border">
                            <h3 class="card-title">Maklumat permohonan perjalanan Keluar Negara</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="{{ url('kemaskini-rombongan') }}" method="post" autocomplete="off"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @foreach ($rombongan as $rmbgn)
                                    <input type="hidden" name="id" id="id" value="{{ $rmbgn->rombongans_id }}">
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><i class="fa fa-calendar"></i> Tarikh Terima Insuran</label>
                                                <div class="input-group date">
                                                    <input type="text"
                                                        class="form-control pull-right datepicker"name="tarikhInsuranRom"
                                                        value="{{ $rmbgn->tarikhInsuranRom->format('d-m-Y') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><i class="fa fa-calendar"></i> Tarikh Mula Rombongan</label>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control datepicker"
                                                            name="tarikhmula"
                                                            value="{{ $rmbgn->tarikhMulaRom->format('d-m-Y') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><i class="fa fa-calendar"></i> Tarikh Akhir Rombongan</label>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control datepicker"
                                                            name="tarikhakhir"
                                                            value="{{ $rmbgn->tarikhAkhirRom->format('d-m-Y') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><i class="fa fa-edit"></i> Tujuan Permohonan</label>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="tujuanRom"
                                                            id="tujuanRom" aria-describedby="helpId" placeholder=""
                                                            value="{{ $rmbgn->tujuanRom }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><i class="fa fa-globe"></i> Negara</label>
                                                <div class="input-group">
                                                    <select style="width: 100%;" id="negaraRom"
                                                        class="form-control select2bs4" name="negaraRom"
                                                        required="required">
                                                        <option value="" selected="selected"></option>
                                                        @foreach ($negara as $jaw)
                                                            <option value="{{ $jaw->namaNegara }}"
                                                                {{ $jaw->namaNegara == $rmbgn->negaraRom ? 'selected' : '' }}>
                                                                {{ $jaw->namaNegara }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="icheck-primary">
                                                    <input class="form-check-input" OnChange="javascript:pilihNegaraLain();"
                                                        type="checkbox" value="1" name="negaraRom_lebih"
                                                        id="negaraRom_lebih" @checked($rmbgn->negaraRom_lebih == '1')>
                                                    <label class="form-check-label" for="negaraRom_lebih">
                                                        Adakah rombongan lebih daripada 1 negera?
                                                    </label>
                                                </div>
                                                <label><i class="fas fa-globe"></i> Negara Tambahan<span
                                                        style="color:red;">*</span></label>
                                                @php
                                                    $selected = explode(', ', $rmbgn->negaraRom_tambahan);
                                                @endphp
                                                <select class="form-control select2bs4" name="negaraRom_tambahan[]"
                                                    id="negaraRom_tambahan" style="width: 100%;" multiple>
                                                    <option value="">SILA PILIH</option>
                                                    @foreach ($negara as $jaw)
                                                        <option value="{{ $jaw->namaNegara }}"
                                                            @selected(in_array($jaw->namaNegara, $selected))>
                                                            {{ $jaw->namaNegara }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><i class="fas fa-money-bill"></i> Sumber Kewangan</label>
                                                <div class="input-group">
                                                    {!! Form::select(
                                                        'jenisKewanganRom',
                                                        [
                                                            '' => 'Sila pilih',
                                                            'Kerajaan' => 'Kerajaan',
                                                            'Federal' => 'Federal',
                                                            'Persendirian' => 'Persendirian',
                                                            'Jabatan' => 'Jabatan',
                                                            'Syarikat' => 'Syarikat',
                                                            'lain-lain' => 'lain-lain',
                                                        ],
                                                        $rmbgn->jenisKewanganRom,
                                                        ['class' => 'form-control', 'required'],
                                                    ) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><i class="fa fa-edit"></i> Jenis Rombongan</label>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <select style="width: 100%;" id="jenis_rombongan"
                                                            class="form-control select2bs4" name="jenis_rombongan"
                                                            required="required">
                                                            <option value="" selected="selected"></option>
                                                            <option value="Rasmi"
                                                                {{ 'Rasmi' == $rmbgn->jenis_rombongan ? 'selected' : '' }}>
                                                                Rasmi</option>
                                                            <option value="Tidak Rasmi"
                                                                {{ 'Tidak Rasmi' == $rmbgn->jenis_rombongan ? 'selected' : '' }}>
                                                                Tidak Rasmi</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><i class="fas fa-money-bill"></i> Anggaran Belanja(RM)</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="anggaranBelanja"
                                                        id="anggaranBelanja" placeholder=""
                                                        value="{{ $rmbgn->anggaranBelanja }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label><i class="fas fa-edit"></i> Alamat Rombongan</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-map-o"></i>
                                                    </div>
                                                    <textarea class="form-control" name="alamatRom" id="alamatRom" cols="170">{{ $rmbgn->alamatRom }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="catatan_permohonan">Catatan</label>
                                                <textarea class="form-control" name="catatan_permohonan" id="catatan_permohonan" rows="3">{{ $rmbgn->catatan_permohonan }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><i class="fa fa-user-friends"></i> Senarai Peserta</label>
                                                <br>
                                                <p class="text-muted" style="text-transform: uppercase">
                                                    @foreach ($peserta as $peser)
                                                        @if ($peser->statusPermohonan == 'Permohonan Berjaya')
                                                        @endif
                                                        <a data-toggle="modal" href='#mdl-kemaskini'
                                                            data-nama="{{ $peser->user->nama }}"
                                                            data-nokp="{{ $peser->user->nokp }}"
                                                            data-email="{{ $peser->user->email }}"
                                                            data-jawatan="{{ $peser->user->jawatan }}"
                                                            data-jabatan="{{ $peser->user->jabatan }}">
                                                            {{ $peser->user->nama }}</a>
                                                        <i>
                                                            @if ($peser->statusPermohonan == 'Ketua Jabatan')
                                                                (Perlu Sokongan Ketua Jabatan)
                                                            @elseif ($peser->statusPermohonan == 'Lulus Semakan BPSM')
                                                                (Disokong oleh ketua Jabatan)
                                                            @elseif ($peser->statusPermohonan == 'Permohonan Gagal')
                                                                (Permohonan ditolak)
                                                            @endif

                                                        </i>
                                                        <br>
                                                    @endforeach
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            @if ($rmbgn->jenis_rombongan == 'Rasmi')
                                                <div class="form-group">
                                                    <label><i class="fas fa-file"></i> Dokumen Rasmi</label>
                                                    <div class="input-group">
                                                        <div class="custom-file ">
                                                            <input type="file" class="custom-file-input"
                                                                name="fileRasmiRom[]" id="exampleInputFile" multiple>
                                                            <label class="custom-file-label" for="exampleInputFile">Pilih
                                                                Fail</label>
                                                        </div>
                                                        {{-- <input type="file" class="custom-file-input" name="fileRasmiRom[]" multiple> --}}
                                                    </div>
                                                    <div class="mt-2">
                                                        @if ($dokumen->isEmpty())
                                                            Tiada Dokumen.
                                                        @else
                                                            @php
                                                                $i = 1;
                                                            @endphp
                                                            @foreach ($dokumen as $doku)
                                                                <div class="btn-group">
                                                                    <a class="btn btn-sm btn-info"
                                                                        href="{{ route('detailPermohonanDokumen.download', ['id' => $doku->dokumens_id]) }}">Dokumen
                                                                        Rombongan {{ $i++ }}</a>
                                                                    <a class="btn btn-sm btn-danger"
                                                                        href="{{ route('detailPermohonan.deleteFileRasmi', ['id' => $doku->dokumens_id]) }}"
                                                                        onclick="javascript: return confirm('Padam dokumen ini?');"
                                                                        alt="Padam Dokumen"><i
                                                                            class="fas fa-backspace"></i></a>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                            @endif
                                        </div>
                                        <div class="col-md-12 text-center">
                                            <a class="btn btn-danger" href="{{ url('senaraiPermohonanProses') }}"
                                                role="button">Kembali</a>
                                            {!! Form::submit('Kemaskini', ['class' => 'btn btn-primary']) !!}
                                        </div>
                                    </div>
                                @endforeach
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        {{-- <button type="submit" class="btn btn-primary">Kemaskini</button> --}}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <!-- Select2 -->
    <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('adminlte/plugins/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- bootstrap datepicker -->
    <script src="{{ asset('adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}">
    </script>

    <script>
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

    <script type="text/javascript" language="javascript">
        function pilihNegaraLain() {
            if (document.getElementById("negaraRom_lebih").checked == true)
                document.getElementById("negaraRom_tambahan").disabled = false;
            else
                document.getElementById("negaraRom_tambahan").disabled = true;
        }
    </script>

    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2();
            //Date range picker
            $('#reservation').daterangepicker()
            //Date range as a button
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                            'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function(start, end) {
                    $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                        'MMMM D, YYYY'))
                }
            )

        });

        $('.datepicker').datepicker({
            autoclose: true,
            format: 'd-m-yyyy'
        })

        // $(function() {
        //     $("#datepicker").datepicker({
        //         changeMonth: true,
        //         changeYear: true,
        //         dateFormat: 'yy-mm-dd'
        //     });

        //     $("#datepicker1").datepicker({
        //         changeMonth: true,
        //         changeYear: true,
        //         dateFormat: 'yy-mm-dd'
        //     });

        //     $("#datepicker2").datepicker({
        //         changeMonth: true,
        //         changeYear: true,
        //         dateFormat: 'yy-mm-dd'
        //     });
        // });
    </script>

@endsection
