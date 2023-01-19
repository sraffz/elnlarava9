<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Individu</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte-3/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte-3/dist/css/adminlte.min.css') }}">

    <style>
        .table td {
            font-size: 13px;
            vertical-align: middle;
            font-weight: bold;
            text-transform: uppercase;
        }

        .table th {
            font-size: 14px
        }

    </style>
</head>

<body>
    <p align="center"><img src="{{ asset('adminlte/dist/img/kelantan.png') }}" width="200" height="150"
            alt="User Image" align="center"><br></p>
    <p align="center"><strong>LAPORAN INDIVIDU KE LUAR NEGARA BAGI PENJAWAT AWAM NEGERI KELANTAN</strong></p>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-borderless table-sm">
                <tbody>
                    <tr>
                        <th style="width: 45%" class="text-right">Nama</th>
                        <th style="width: 3%" class="text-center">:</th>
                        <td style="width: 45%">{{ $user->nama }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Kad Pengenalan</th>
                        <th class="text-center">:</th>
                        <td>{{ $user->nokp }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Jawatan & Gred</th>
                        <th class="text-center">:</th>
                        <td>{{ $user->namaJawatan }} ({{ $user->kod }}{{ $user->gred }})</td>
                    </tr>
                    <tr>
                        <th class="text-right">Jabatan</th>
                        <th class="text-center">:</th>
                        <td>{{ $user->nama_jabatan }} ({{ $user->kod_jabatan }})</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered table-sm">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th style="vertical-align: middle">BIL</th>
                        <th style="vertical-align: middle">NEGARA</th>
                        <th style="vertical-align: middle">JENIS PERMOHONAN</th>
                        <th style="vertical-align: middle">TEMPOH PERJALANAN</th>
                        <th style="vertical-align: middle">TARIKH LULUS</th>
                        <th style="vertical-align: middle">STATUS PERMOHONAN</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($negara as $dd)
                        <tr class="text-center">
                            <td style="vertical-align: middle">{{ $i++ }}</td>
                            <td class="text-left" style="vertical-align: middle">
                                {{ $dd->negara }}</td>
                            <td style="vertical-align: middle">{{ $dd->JenisPermohonan }}</td>
                            @php
                                $formatted_dt1 = \Carbon\Carbon::parse($dd->tarikhMulaPerjalanan);
                                
                                $formatted_dt2 = \Carbon\Carbon::parse($dd->tarikhAkhirPerjalanan);
                                
                                $beza = $formatted_dt1->diffInDays($formatted_dt2);
                            @endphp
                            <td style="vertical-align: middle">
                                {{ \Carbon\Carbon::parse($dd->tarikhMulaPerjalanan)->format('d/m/y') }}
                                -
                                {{ \Carbon\Carbon::parse($dd->tarikhAkhirPerjalanan)->format('d/m/y') }}
                                ({{ $beza }} Hari)</td>
                            <td style="vertical-align: middle">
                                {{ \Carbon\Carbon::parse($dd->tarikhLulusan)->format('d/m/y') }}
                            </td>
                            <td style="vertical-align: middle">
                                @if ($dd->status_rombongan == 'Permohonan Gagal')
                                    Gagal
                                @else
                                    {{ substr($dd->statusPermohonan, 11) }}
                                    @if ($dd->pengesahan_pembatalan == 1)
                                        (DIBATALKAN)
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>


    {{-- <script src="{{ asset('adminlte-3/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('adminlte-3/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte-3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
</body>

</html>
