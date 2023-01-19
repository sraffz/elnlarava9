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
        <p align="center"><strong>LAPORAN MENGIKUT BULANAN PERJALANAN PEGAWAI AWAM KE LUAR NEGARA <BR>BAGI TAHUN
                {{ $year }}</strong></p> <br>
        <table class="table table-bordered table-sm">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center" style="width: 50%">BULAN</th>
                    <th class="text-center">JUMLAH PEGAWAI</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">Januari</td>
                    <td class="text-center">
                        @foreach ($bil as $jbil)
                            @if ($jbil->bulan == 1)
                                {{ $jbil->bil }}
                            @endif
                        @endforeach
                    </td>
                </tr>

                <tr>
                    <td class="text-center">Febuari</td>
                    <td class="text-center">
                        @foreach ($bil as $jbil)
                            @if ($jbil->bulan == 2)
                                {{ $jbil->bil }}
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="text-center">Mac</td>
                    <td class="text-center">
                        @foreach ($bil as $jbil)
                            @if ($jbil->bulan == 3)
                                {{ $jbil->bil }}
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="text-center">April</td>
                    <td class="text-center">
                        @foreach ($bil as $jbil)
                            @if ($jbil->bulan == 4)
                                {{ $jbil->bil }}
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="text-center">Mei</td>
                    <td class="text-center">
                        @foreach ($bil as $jbil)
                            @if ($jbil->bulan == 5)
                                {{ $jbil->bil }}
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="text-center">Jun</td>
                    <td class="text-center">
                        @foreach ($bil as $jbil)
                            @if ($jbil->bulan == 6)
                                {{ $jbil->bil }}
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="text-center">Julai</td>
                    <td class="text-center">
                        @foreach ($bil as $jbil)
                            @if ($jbil->bulan == 7)
                                {{ $jbil->bil }}
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="text-center">Ogos</td>
                    <td class="text-center">
                        @foreach ($bil as $jbil)
                            @if ($jbil->bulan == 8)
                                {{ $jbil->bil }}
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="text-center">September</td>
                    <td class="text-center">
                        @foreach ($bil as $jbil)
                            @if ($jbil->bulan == 9)
                                {{ $jbil->bil }}
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="text-center">Oktober</td>
                    <td class="text-center">
                        @foreach ($bil as $jbil)
                            @if ($jbil->bulan == 10)
                                {{ $jbil->bil }}
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="text-center">November</td>
                    <td class="text-center">
                        @foreach ($bil as $jbil)
                            @if ($jbil->bulan == 11)
                                {{ $jbil->bil }}
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="text-center">Disember</td>
                    <td class="text-center">
                        @foreach ($bil as $jbil)
                            @if ($jbil->bulan == 12)
                                {{ $jbil->bil }}
                            @endif
                        @endforeach
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-center">JUMLAH KESELURUHAN</th>
                    <th class="text-center">{{ $jumlah }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <script src="{{ asset('adminlte-3/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('adminlte-3/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte-3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</html>
