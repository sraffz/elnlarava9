<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Senarai Permohonan Keluar Negara</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>       
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .table tr td {
            vertical-align: middle;
            text-transform: uppercase;
            font-size: 12px;
            font-weight: bold;
        }
        
        .table tr th {
            vertical-align: middle;
            text-transform: uppercase;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class=" ">
        <div class="row">
            <div class="col-md-12 text-center">
                <h3 style="text-transform: uppercase">Senarai Permohonan Perjalanan Pegawai Awam Ke Luar Negara Secara
                    Individu</h3>
                <br>
                <br>
                <table class="table table-bordered table-sm" width="100%">
                    <thead class="thead-dark">
                        <tr style="text-transform: uppercase" class="text-center">
                            <th style="width: 3%" rowspan="2">Bil</th>
                            <th style="width: 25%" rowspan="2">Nama</th>
                            <th rowspan="2">Jabatan</th>
                            <th rowspan="2">Tarikh Permohonan</th>
                            <th rowspan="2">Negara</th>
                            <th rowspan="2">Tarikh Mula Perjalanan</th>
                            <th rowspan="2">Jenis Permohonan</th>
                            <th colspan="2">Tindakan</th>
                        </tr>
                        <tr class="text-center">
                            <th style="vertical-align: middle; width: 8%">LULUS</th>
                            <th style="vertical-align: middle; width: 8%">TOLAK</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permohonan as $index => $mohonan)
                            <tr class="text-center">
                                <td> {{ $index + 1 }}</td>
                                <td class="text-left" style="text-transform: uppercase">
                                    {{ $mohonan->nama }}
                                </td>
                                <td>{{ $mohonan->kod_jabatan }}</td>
                                {{-- <td>{{ $mohonan->user->userJabatan->kod_jabatan }}</td> --}}
                                <td>{{ \Carbon\Carbon::parse($mohonan->tarikhmohon)->format('d/m/Y') }}
                                </td>
                                <td>{{ $mohonan->negara }}@if ($mohonan->negara_lebih_dari_satu == 1){{ ', '.$mohonan->negara_tambahan }}
                                @endif</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($mohonan->tarikhMulaPerjalanan)->format('d/m/Y') }} -
                                    {{ \Carbon\Carbon::parse($mohonan->tarikhAkhirPerjalanan)->format('d/m/Y') }}

                                    @php
                                        $tempoh = \Carbon\Carbon::parse($mohonan->tarikhAkhirPerjalanan)
                                                                ->diff(\Carbon\Carbon::parse($mohonan->tarikhMulaPerjalanan))
                                                                ->format('%d Hari');
                                    @endphp
                                    <br>({{ $tempoh  }})
                                </td>
                                <td>{{ $mohonan->JenisPermohonan }}</td>
                                <td>
                                       {{-- <span style="font-size:30px; padding-left:30%;border:1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> --}}
                                </td>
                                <td>
                                      {{-- <span style="font-size:30px; padding-left:30%;border:1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> --}}
                                </td>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

       <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
       <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
       <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>
