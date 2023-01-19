<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('adminlte-3/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte-3/dist/css/adminlte.min.css') }}">

    <style>
        table td {
            font-size: 15px;
            font-weight: bold;
            text-transform: uppercase;
        }

    </style>
</head>

<body>
    <div class="container">
        <p align="center"><img src="{{ asset('adminlte/dist/img/kelantan.png') }}" width="200" height="150"
                alt="User Image" align="center"><br></p>
        <p align="center"><strong>LAPORAN MENGIKUT TAHUN PERJALANAN PEGAWAI AWAM KE LUAR NEGARA</strong></p> <br>
        <table class="table table-bordered table-sm">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center" style="width: 50%">TAHUN</th>
                    <th class="text-center">JUMLAH PEGAWAI</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $dtahun)
                    <tr class="text-center">
                        <td>{{ $dtahun->tahun }}</td>
                        <td>{{ $dtahun->bil }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="{{ asset('adminlte-3/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('adminlte-3/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte-3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</html>
