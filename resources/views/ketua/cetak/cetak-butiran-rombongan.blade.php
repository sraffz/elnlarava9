<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Butiran Permohonan</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    {{-- <link rel="stylesheet" href="{{ asset('adminlte-3/dist/css/adminlte.min.css') }}"> --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}
    <style>
        .table td {
            font-size: 13px;
            vertical-align: middle;
        }

        .table th {
            font-size: 14px
        }

        .break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <p align="center"><img src="{{ asset('adminlte/dist/img/kelantan.png') }}" width="160" height="120"
            alt="User Image" align="center"><br></p>
    <p style="text-transform: uppercase; font-size:17px" align="center">
        <strong>
            PERMOHONAN PERJALANAN PEGAWAI AWAM KE LUAR NEGARA <br>
            secara Rombongan
        </strong>
    </p>

    <div class="text-center">
        <table class="table table-bordered table-sm">
            <thead class="thead-dark">
                <tr>
                    <th colspan="2" class="text-left">MAKLUMAT PERJALANAN KE LUAR NEGARA</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-left" style="width: 30%"><strong>Kod Rombongan</strong> </td>
                    <td class="text-left"><strong>{{ $permohonan->codeRom }}</strong> </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 30%"><strong>Tempoh Lawatan</strong> </td>
                    <td class="text-left">
                        <strong>{{ \Carbon\Carbon::parse($permohonan->tarikhMulaRom)->format('d/m/Y') }}
                            sehingga
                            {{ \Carbon\Carbon::parse($permohonan->tarikhAkhirRom)->format('d/m/Y') }}
                            ({{ $jumlahDate }} Hari)</strong>
                    </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 30%"><strong>Negara Yang Dilawati</strong> </td>
                    <td class="text-left"><strong>{{ $permohonan->negaraRom }}</strong> </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 30%"><strong>Tujuan Lawatan</strong> </td>
                    <td class="text-left"><strong>{{ $permohonan->tujuanRom }}</strong> </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 30%"><strong>Alamat Semasa Bercuti</strong> </td>
                    <td class="text-left"><strong>{{ $permohonan->alamatRom }} </strong> </td>
                </tr>
            </tbody>
        </table>

        @if (count($pengesahan)>0)
        <table class="table table-bordered table-sm">
            <thead class="thead-dark">
                <tr>
                    <th colspan="2" class="text-left">PENGESAHAN KETUA BAHAGIAN</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-left" style="width: 30%"><strong>Nama Ketua Bahagian</strong> </td>
                    <td class="text-left"><strong>{{ $pengesahan->nama }}</strong> </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 30%"><strong>Jawatan/Gred</strong> </td>
                    <td class="text-left"><strong>{{ $pengesahan->jawatan_pengesah }}
                            ({{ $pengesahan->gred_pengesah }})</strong></td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 30%"><strong>Jabatan</strong> </td>
                    <td class="text-left"><strong>{{ $pengesahan->nama_jabatan }}</strong></td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 30%"><strong>Ulasan</strong> </td>
                    <td class="text-left">
                        <strong>{{ $pengesahan->ulasan_pengesahan }}</strong>
                    </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 30%"><strong>Tarikh</strong> </td>
                    <td class="text-left">
                        <strong>{{ date('d/m/Y', strtotime($pengesahan->tarikh_pengesah)) }}</strong>
                    </td>
                </tr>
            </tbody>
        </table>
        @endif

        <table class="table table-bordered table-sm">
            <thead class="thead-dark">
                <tr>
                    <th colspan="6" class="text-left">SENARAI PESERTA ROMBONGAN</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>BIL</strong> </td>
                    <td><strong>NAMA</strong> </td>
                    <td><strong>NO. KP</strong> </td>
                    <td><strong>JAWATAN & GRED</strong></td>
                    <td><strong>LULUS</strong></td>
                    <td><strong>TOLAK</strong></td>
                </tr>
                @php
                    $i = 1;
                @endphp
                @foreach ($allPermohonan as $index => $element)
                    @if ($element->rombongans_id == $permohonan->rombongans_id)
                        <tr>
                            <td class="text-center"><strong> {{ $i++ }}</strong></td>
                            <td class="text-left">
                                <strong> 
                                    {{ $element->nama }}
                                    @if ($element->usersID == $permohonan->ketua_rombongan)
                                        (Ketua Rombongan)
                                    @endif
                                </strong> 
                            </td>
                            <td><strong> {{ $element->nokp }}</strong></td>
                            <td><strong>  {{ $element->namaJawatan }} ({{ $element->gred }})</strong></td>
                            <td>
                                {{-- <span style="font-size:30px; padding-left:30%;border:1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> --}}
                         </td>
                         <td>
                               {{-- <span style="font-size:30px; padding-left:30%;border:1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> --}}
                         </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table> <br>
        <strong>Tarikh Permohonan : {{ \Carbon\Carbon::parse($tarikhmohon)->format('d/m/Y') }}</strong>

        <br>
        <div class="text-center">
            <p>
                <i> *Borang ini janaan komputer dan tidak memerlukan tandatangan*</i>
            </p>
        </div>


    </div>

    {{-- <script src="{{ asset('adminlte-3/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('adminlte-3/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte-3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
</body>

</html>
