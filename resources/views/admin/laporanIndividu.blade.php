<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan Dato</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        .table thead th {
            background-color: #227292;
            color: white;
            font-size: 12px;
        }

        .table tbody td {
            font-size: 12px;
            font-weight: bold;
        }

    </style>
</head>

<body>
    <div class="text-center">
        <p>
            <strong>
                LAPORAN PERJALANAN PEGAWAI  KE LUAR NEGARA ATAS URUSAN RASMI/PERSENDIRIAN
                <BR>BAGI TAHUN {{ now()->year }}
            </strong>
        </p>
    </div>
    <div>
        <table class="table table-bordered table-sm">
            <thead class="thead-dark">
                <tr>
                    <th style="vertical-align: middle; text-align: center; width: 2%" rowspan="2">BIL</th>
                    <th style="vertical-align: middle; text-align: center; width: 8%" rowspan="2">NAMA / JAWATAN</th>
                    {{-- <th style="vertical-align: middle; text-align: center; width: 8%" rowspan="2">JAWATAN/GRED</th> --}}
                    <th style="vertical-align: middle; text-align: center; width: 8%" rowspan="2">JABATAN</th>
                    <th style="vertical-align: middle; text-align: center; width: 8%" rowspan="2">TUJUAN PERMOHONAN
                    </th>
                    <th style="vertical-align: middle; text-align: center; width: 5%" rowspan="2">NEGARA</th>
                    <th style="vertical-align: middle; text-align: center; width: 8%" colspan="2">TARIKH</th>
                    <th style="vertical-align: middle; text-align: center; width: 8%" rowspan="2">SUMBER KEWANGAN/JENIS
                        PERMOHONAN
                    </th>
                    <th style="vertical-align: middle; text-align: center; width: 8%" rowspan="2">KELULUSAN PERMOHONAN
                    </th>
                    <th style="vertical-align: middle; text-align: center; width: 8%" rowspan="2">ULASAN</th>
                </tr>
                <tr>
                    <th style="vertical-align: middle; text-align: center">PERGI</th>
                    <th style="vertical-align: middle; text-align: center">BALIK</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $index => $mohonan)
                    <tr class="text-center">
                        <td>{{ $index + 1 }}</td>
                        <td class="text-left">{{ $mohonan->nama }} <br> {{ $mohonan->namaJawatan }}
                            ({{ $mohonan->gred_kod_abjad }}{{ $mohonan->gredAngka }})</td>
                        <td>{{ $mohonan->nama_jabatan }}</td>
                        <td>{{ $mohonan->lainTujuan }}</td>
                        <td>{{ $mohonan->negara }}</td>
                        <td>{{ \Carbon\Carbon::parse($mohonan->tarikhMulaPerjalanan)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($mohonan->tarikhAkhirPerjalanan)->format('d/m/Y') }}</td>
                        <td>{{ $mohonan->jenisKewangan }}/{{ $mohonan->JenisPermohonan }}</td>
                        <td>
                            @if ($mohonan->statusPermohonan == 'Permohonan Berjaya')
                                <span>Diluluskan</span>
                            @elseif($mohonan->statusPermohonan == "Permohonan Gagal")
                                <span>Ditolak</span>
                            @endif
                        </td>
                        <td>
                            Bil. Keluar Negara:
                            @foreach ($bilkluarneagara as $bkn)
                                @if ($bkn->usersID == $mohonan->usersID)
                                    {{ $bkn->bil }}
                                @endif
                            @endforeach

                            {{-- {{ $mohonan->jumlahKeluarNegara($mohonan->usersID) }}</small> --}}
                            <br>
                            <br>
                            Tempoh Permohonan: <br>
                            @if ($mohonan->jumlahHariPermohonanBerlepas <= 14)
                                {{ $mohonan->jumlahHariPermohonanBerlepas }}
                            @else
                                {{ $mohonan->jumlahHariPermohonanBerlepas }}
                            @endif
                            Hari
                        </td>

                        @php
                            $a = [];
                        @endphp

                @endforeach
             
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
</body>

</html>
