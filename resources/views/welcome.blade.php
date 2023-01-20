<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistem e-Luar Negara : Log Masuk</title>
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
    {{-- @vite([
        // 'resources/sass/app.scss',
        // 'resources/js/app.js',
        'public/adminlte-3/plugins/fontawesome-free/css/all.min.css',
        'public/adminlte-3/plugins/icheck-bootstrap/icheck-bootstrap.min.css',
        'public/adminlte-3/dist/css/adminlte.min.css',
        'public/adminlte-3/plugins/jquery/jquery.min.js',
        'public/adminlte-3/plugins/bootstrap/js/bootstrap.bundle.min.js',
        'public/adminlte-3/dist/js/adminlte.min.js',
        // 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback',
    ]) --}}
    <style>
        body {
            background-image: url('{{ asset('/img/mabna222.png') }}');
            background-size: cover;
            background-position: top center;
            align-items: center;
        }
    </style>
</head>

<body class="hold-transition login-page" filter-color="black">

    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('img/logoKelantan.png') }}" alt="" height="30%" width="30%">
                {{-- <h3>SISTEM E-LUAR NEGARA</h3> --}}
            </a>
        </div>
        <!-- /.login-logo -->
        <div class="card card-outline card-danger">
            <div class="card-header register-card-header text-center">
                <h3>SISTEM E-LUAR NEGARA</h3>
            </div>
            <div class="card-body login-card-body">
                <p class="login-box-msg">Log masuk untuk membuat permohonans</p>
                <form action="{{ route('login') }}" method="post">
                    {{ csrf_field() }}
                    <div class="input-group mb-3">
                        <input type="text" name="nokp"
                            class="form-control {{ $errors->has('nokp') ? ' is-invalid' : '' }}"
                            placeholder="No Kad Pengenalan" value="{{ old('nokp') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-id-card-alt"></span>
                            </div>
                        </div>
                        @if ($errors->has('nokp'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('nokp') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password"
                            class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                            placeholder="Kata Laluan" required>
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
                    <div class="row">
                        <div class="col-7">

                        </div>
                        <!-- /.col -->
                        <div class="col-5">
                            <button type="submit" class="btn btn-danger btn-block">Log Masuk</button>

                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <p class="mb-1">
                    <a href="{{ url('password/reset') }}">Lupa Kata laluan</a>
                </p>
                <p class="mb-0">
                    <a href="{{ url('registerBaru') }}" class="text-center">Daftar Akaun</a>
                </p>

            </div>
            <div class="card-footer">
                <div class="text-right">
                    <a href="{{ route('panduan-pengguna') }}">Panduan Pengguna</a>
                </div>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>

    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('adminlte-3/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte-3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte-3/dist/js/adminlte.min.js') }}"></script>

</body>

</html>
