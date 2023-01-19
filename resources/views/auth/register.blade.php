<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistem e-Luar Negara : Daftar Pengguna</title>
    <link rel="icon" type="image/png" href="{{ asset('img/sukk.png') }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte-3/dist/css/adminlte.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/daterangepicker/daterangepicker.css') }}">

    @vite([
        // 'resources/sass/app.scss',
        // 'resources/js/app.js',
        'public/adminlte-3/plugins/fontawesome-free/css/all.min.css',
        'public/adminlte-3/plugins/icheck-bootstrap/icheck-bootstrap.min.css',
        'public/adminlte-3/dist/css/adminlte.min.css',
        'public/adminlte-3/plugins/select2/css/select2.min.css',
        'public/adminlte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css',
        'public/adminlte-3/plugins/daterangepicker/daterangepicker.css',
        'public/adminlte-3/plugins/jquery/jquery.min.js',
        'public/adminlte-3/plugins/bootstrap/js/bootstrap.bundle.min.js',
        'public/adminlte-3/dist/js/adminlte.min.js',
        'public/adminlte-3/plugins/select2/js/select2.full.min.js',
        'public/adminlte-3/plugins/bootstrap/js/bootstrap.bundle.min.js',
        'public/adminlte-3/plugins/moment/moment.min.js',
        'public/adminlte-3/plugins/inputmask/jquery.inputmask.min.js',
    ])
</head>

<body class="hold-transition login-page"
    style="background-image: url('{{ asset('/img/mabna222.png') }}'); background-size: cover; background-position: top center;align-items: center;">
    <br><br>
    <div class="register-box">
        <div class="register-logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('img/logoKelantan.png') }}" alt="" height="30%" width="30%">
            </a>
        </div>
        <div class="card card-outline card-danger">
            <div class="card-header register-card-header text-center">
                <h3>SISTEM E-LUAR NEGARA</h3>
            </div>
            <div class="card-body register-card-body">
                <p class="login-box-msg">Daftar untuk mencipta akaun</p>

                <form method="POST" action="{{ route('register') }}" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="input-group mb-3">
                        <input type="text"
                            class="form-control upcase {{ $errors->has('nama') ? ' is-invalid' : '' }}"
                            placeholder="Nama Pegawai" name="nama" value="{{ old('nama') }}" required autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        @if ($errors->has('nama'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('nama') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" max="12"
                            class="form-control {{ $errors->has('nokp') ? ' is-invalid' : '' }}"
                            placeholder="No. Kad Pengenalan" name="nokp" value="{{ old('nokp') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-id-card-alt"></span>
                            </div>
                        </div>
                        @if ($errors->has('nokp'))
                            <span class="invalid-feedback" role="alert">
                                <strong>No Kad Pengenalan Telah Berdaftar</strong>
                            </span>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                            placeholder="Email" name="email" value="{{ old('email') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <select name="jantina" id="jantina"
                            class="form-control {{ $errors->has('jantina') ? ' is-invalid' : '' }} select22" required>
                            <option value="">Pilih Jantina</option>
                            <option value="Lelaki" {{ old('jantina') == 'Lelaki' ? 'selected' : '' }}>Lelaki</option>
                            <option value="Perempuan" {{ old('jantina') == 'Perempuan' ? 'selected' : '' }}>Perempuan
                            </option>
                        </select>
                        @if ($errors->has('jantina'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('jantina') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <select id="jawatan"
                            class="form-control {{ $errors->has('jawatan') ? ' is-invalid' : '' }} select22"
                            name="jawatan" required>
                            <option value="">Pilih Jawatan</option>
                            @foreach ($jawatan as $jaw)
                                <option value="{{ $jaw->idJawatan }}"
                                    {{ old('jawatan') == $jaw->idJawatan ? 'selected' : '' }}>
                                    {{ $jaw->namaJawatan }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('jawatan'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('jawatan') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <select id="gredKod"
                                    class="form-control {{ $errors->has('gredKod') ? ' is-invalid' : '' }} select22"
                                    name="gredKod" required="required">
                                    <option value="">Pilih Kod Gred</option>
                                    @foreach ($gredKod as $gredKods)
                                        <option value="{{ $gredKods->gred_kod_ID }}"
                                            {{ old('gredKod') == $gredKods->gred_kod_ID ? 'selected' : '' }}>
                                            {{ $gredKods->gred_kod_abjad }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select id="gredAngka"
                                    class="form-control {{ $errors->has('gredAngka') ? ' is-invalid' : '' }} select22"
                                    name="gredAngka" required="required">
                                    <option value="">Pilih Gred</option>
                                    @foreach ($gredAngka as $gredAngkas)
                                        <option value="{{ $gredAngkas->gred_angka_ID }}"
                                            {{ old('gredAngka') == $gredAngkas->gred_angka_ID ? 'selected' : '' }}>
                                            {{ $gredAngkas->gred_angka_nombor }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <select name="taraf" id="taraf"
                            class="form-control {{ $errors->has('taraf') ? ' is-invalid' : '' }} select22" required>
                            <option value="">Pilih Taraf</option>
                            <option value="Tetap" {{ old('taraf') == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                            <option value="Jawatan Berasaskan Caruman (JBC)"
                                {{ old('taraf') == 'Jawatan Berasaskan Caruman (JBC)' ? 'selected' : '' }}>Jawatan
                                Berasaskan Caruman (JBC)
                            </option>
                            <option value="Sementara" {{ old('taraf') == 'Sementara' ? 'selected' : '' }}>Sementara
                            </option>
                            <option value="Contract Of Service (COS)"
                                {{ old('taraf') == 'Contract Of Service (COS)' ? 'selected' : '' }}>Contract Of Service
                                (COS)</option>
                            <option value="Contract For Service (CFS)"
                                {{ old('taraf') == 'Contract For Service (CFS)' ? 'selected' : '' }}>Contract For
                                Service (CFS)</option>
                            <option value="Berelaun" {{ old('taraf') == 'Berelaun' ? 'selected' : '' }}>Berelaun
                            </option>
                            <option value="Sambilan" {{ old('taraf') == 'Sambilan' ? 'selected' : '' }}>Sambilan
                            </option>
                        </select>
                        @if ($errors->has('taraf'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('taraf') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="input-group mb-3">
                        <select id="jabatan"
                            class="form-control {{ $errors->has('jabatan') ? ' is-invalid' : '' }} select22"
                            name="jabatan" required>
                            <option value="">Pilih Jabatan</option>
                            @foreach ($jabatan as $jab)
                                <option value="{{ $jab->jabatan_id }}"
                                    {{ old('jabatan') == $jab->jabatan_id ? 'selected' : '' }}>
                                    {{ $jab->nama_jabatan }}({{ $jab->kod_jabatan }})</option>
                            @endforeach
                        </select>
                        @if ($errors->has('jabatan'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('jabatan') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <input id="password" type="password"
                            class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}{{ $errors->has('password') ? ' is-invalid' : '' }}"
                            name="password" required placeholder="kata Laluan">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <input id="password-confirm" type="password"
                            class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                            name="password_confirmation" required placeholder="Taip Semula Kata Laluan">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @if ($errors->has('password_confirmation'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-8">
                            {{-- <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                                <label for="agreeTerms">
                                    I agree to the <a href="#">terms</a>
                                </label>
                            </div> --}}
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-danger btn-block">Daftar</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <a href="{{ url('login') }}" class="text-center">Saya telah mempunyai akaun.</a>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <br><br>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="{{ asset('adminlte-3/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte-3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte-3/dist/js/adminlte.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('adminlte-3/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('adminlte-3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ asset('adminlte-3/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('adminlte-3/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
</body>

<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2();

        //Initialize Select2 Elements
        $('.select22').select2({
            theme: 'bootstrap4'
        });

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', {
            'placeholder': 'dd/mm/yyyy'
        })
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', {
            'placeholder': 'mm/dd/yyyy'
        })
        //Money Euro
        $('[data-mask]').inputmask()
    });
</script>
<script>
    $('.upcase').keyup(function() {
        $(this).val($(this).val().toUpperCase());
    });
</script>

</html>
