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
            font-size: 13px
        }
    </style>
</head>

<body>
    <div class="container">
        <p align="center"><img src="{{ asset('adminlte/dist/img/kelantan.png') }}" width="200" height="150"
                alt="User Image" align="center"><br></p>
        <p align="center"><strong>LAPORAN JUMLAH PERMOHONAN PERJALANAN PEGAWAI AWAM KE LUAR NEGARA <BR>BAGI TAHUN
                {{ $tahun }}</strong></p><br>
        <div class="text-center">
            <p><strong>PERMOHONAN BERJAYA</strong></p>
        </div>
        <table class="table table-bordered table-sm">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center" style="width: 50%">LELAKI</th>
                    <th class="text-center">PEREMPUAN</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center"><strong>{{ $countLBerjaya }}</strong> </td>
                    <td class="text-center"><strong>{{ $countPBerjaya }}</strong></td>
                </tr>
            </tbody>
        </table>
        <br><br>
        <div class="text-center">
            <p><strong>PERMOHONAN GAGAL</strong></p>
        </div>
        <table class="table table-bordered table-sm">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center" style="width: 50%">LELAKI</th>
                    <th class="text-center">PEREMPUAN</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center"><strong>{{ $countLGagal }}</strong></td>
                    <td class="text-center"><strong>{{ $countPGagal }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>


    <script src="{{ asset('adminlte-3/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('adminlte-3/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte-3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>


    {{-- <!-- jQuery 3 -->
    <script src="{{ asset('adminlte/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- SlimScroll -->
    <script src="{{ asset('adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('adminlte/bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('adminlte/dist/js/demo.js') }}"></script> --}}
</body>

</html>
