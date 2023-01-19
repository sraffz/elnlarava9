<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Butiran Permohonan</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

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

        footer {
                position: fixed; 
                bottom: -30px; 
                left: 0px; 
                right: 0px;
                height: 50px; 

                /** Extra personal styles **/
                background-color: #ffffff;
                color: rgb(0, 0, 0);
                text-align: center;
                line-height: 35px;
            }
        
    </style>
</head>

<body>
    {{-- <footer>
       <i>Borang ini adalah janaan komputer dan tidak memerlukan tandatangan. </i> 
    </footer> --}}

    <p align="center"><img src="{{ asset('adminlte/dist/img/kelantan.png') }}" width="160" height="120"
            alt="User Image" align="center"><br></p>
    <p style="text-transform: uppercase; font-size:17px" align="center">
        <strong>
            PERMOHONAN PERJALANAN PEGAWAI AWAM KE LUAR NEGARA <br>
            atas URUSAN {{ $permohonan->JenisPermohonan }}
        </strong>
    </p>

    <div class="text-center">
        <table class="table table-bordered table-sm">
            <thead class="thead-dark">
                <tr>
                    <th colspan="2" class="text-left">MAKLUMAT PEMOHON</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-left" style="width: 30%"><strong>Nama Pegawai</strong> </td>
                    <td class="text-left"><strong>{{ $permohonan->user->nama }}</strong> </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 30%"><strong>No. Kad Pengenalan</strong> </td>
                    <td class="text-left"><strong>{{ $permohonan->user->nokp }}</strong> </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 30%"><strong>Tarikh Terima Insurans</strong> </td>
                    <td class="text-left">
                        @php
                            if ($permohonan->tarikhInsuran == '1970-01-01' || $permohonan->tarikhInsuran == null) {
                                $ti = '';
                            } else {
                                $ti = \Carbon\Carbon::parse($permohonan->tarikhInsuran)->format('d/m/Y');
                            }
                            
                        @endphp
                        <strong>{{ $ti }}</strong>
                    </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 30%"><strong>Jawatan/Gred</strong> </td>
                    <td class="text-left"><strong>{{ $permohonan->user->userJawatan->namaJawatan }}
                            ({{ $permohonan->user->userGredKod->gred_kod_abjad }}{{ $permohonan->user->userGredAngka->gred_angka_nombor }})</strong>
                    </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 30%"><strong>Jabatan</strong> </td>
                    <td class="text-left"><strong>{{ $permohonan->user->userJabatan->nama_jabatan }}
                            ({{ $permohonan->user->userJabatan->kod_jabatan }})</strong> </td>
                </tr>
            </tbody>
        </table>

        <table class="table table-bordered table-sm">
            <thead class="thead-dark">
                <tr>
                    <th colspan="2" class="text-left">MAKLUMAT PERJALANAN KE LUAR NEGARA</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-left" style="width: 30%"><strong>Tempoh Lawatan</strong> </td>
                    <td class="text-left">
                        <strong>{{ \Carbon\Carbon::parse($permohonan->tarikhMulaPerjalanan)->format('d/m/Y') }}
                            sehingga
                            {{ \Carbon\Carbon::parse($permohonan->tarikhAkhirPerjalanan)->format('d/m/Y') }}
                            ({{ $jumlahDate }} Hari)</strong>
                    </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 30%"><strong>Negara Yang Dilawati</strong> </td>
                    <td class="text-left"><strong>{{ $permohonan->negara }}</strong> </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 30%"><strong>Tujuan Lawatan</strong> </td>
                    <td class="text-left"><strong>{{ $permohonan->lainTujuan }}</strong> </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 30%"><strong>Alamat Semasa Bercuti</strong> </td>
                    <td class="text-left"><strong>{{ $permohonan->alamat }} </strong> </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 30%"><strong>No. Telefon / Email</strong> </td>
                    <td class="text-left">
                        <strong>{{ $permohonan->telefonPemohon }} / {{ $permohonan->user->email }}</strong>
                    </td>
                </tr>
            </tbody>
        </table>

        @if (count($sejarah)>0)
            <table class="table table-bordered table-sm">
                <thead class="thead-dark">
                    <tr style="text-transform: uppercase">
                        <th class="text-left">Sejarah Keluar Negara</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-left">
                            <strong>
                                @foreach ($sejarah as $sej)
                                    @if ($sej->statusPermohonanRom == 'Permohonan Gagal')
                                    @else
                                        {{ $sej->negara }} ({{ date('d/m/Y', strtotime($sej->tarikhMulaPerjalanan)) }}
                                        -
                                        {{ date('d/m/Y', strtotime($sej->tarikhAkhirPerjalanan)) }}), 
                                    @endif
                                @endforeach
                            </strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        @else
        @endif

        @foreach ($pasangan as $ppp)
            @if ($ppp->namaPasangan != null)
                <table class="table table-bordered table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th colspan="2" class="text-left">MAKLUMAT PASANGAN/KELUARGA/SAUDARA PEGAWAI DI
                                LUAR NEGARA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-left" style="width: 30%"><strong>Nama</strong> </td>
                            <td class="text-left"><strong>{{ $ppp->namaPasangan }}</strong> </td>
                        </tr>
                        <tr>
                            <td class="text-left" style="width: 30%"><strong>Hubungan</strong> </td>
                            <td class="text-left"><strong>{{ $ppp->hubungan }}</strong> </td>
                        </tr>
                        <tr>
                            <td class="text-left" style="width: 30%"><strong>Alamat</strong> </td>
                            <td class="text-left"><strong>{{ $ppp->alamatPasangan }} </strong> </td>
                        </tr>
                        <tr>
                            <td class="text-left" style="width: 30%"><strong>No. Telefon / Email</strong> </td>
                            <td class="text-left">
                                <strong>{{ $ppp->phonePasangan }} / {{ $ppp->emailPasangan }}</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>

            @endif
        @endforeach

        @if ($jumlahDateCuti > 0)
            <table class="table table-bordered table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th colspan="4" class="text-left">MAKLUMAT KELULUSAN CUTI REHAT (SEKIRANYA MEMERLUKAN
                            KELULUSAN CUTI REHAT)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-left" style="width: 25%"><strong>Tarikh Mula Cuti</strong> </td>
                        <td class="text-left">
                            <strong>{{ \Carbon\Carbon::parse($permohonan->tarikhMulaCuti)->format('d/m/Y') }}</strong>
                        </td>
                        <td class="text-left" style="width: 25%"><strong>Tarikh Akhir Cuti</strong> </td>
                        <td class="text-left">
                            <strong>{{ \Carbon\Carbon::parse($permohonan->tarikhAkhirCuti)->format('d/m/Y') }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left" style="width: 25%"><strong>Jumlah Cuti</strong> </td>
                        <td class="text-left"><strong>{{ $jumlahDateCuti }}</strong> </td>
                        <td class="text-left" style="width: 25%"><strong>Tarikh Kembali Bertugas</strong> </td>
                        <td class="text-left">
                            <strong>{{ \Carbon\Carbon::parse($permohonan->tarikhKembaliBertugas)->format('d/m/Y') }}</strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif

        <table class="table table-bordered table-sm">
            <thead class="thead-dark">
                <tr>
                    <th class="text-left">PERAKUAN PEMOHON</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-left">
                        @if ($permohonan->tick == 'yes')
                            <strong>1) Saya dengan ini memenuhi segala peraturan yang ditetapkan di perenggan 6 (i),
                                (ii) dan perenggan 10 Surat Pekeliling Am Bilangan 3 tahun 2021</strong>
                            <br><br>
                            <strong>2) Saya dengan ini mengisytiharkan segala maklumat yang diberikan adalah benar.
                                Sekiranya didapati maklumat ini tidak benar, saya boleh diambil tindakan mengikut
                                peraturan sedia ada.</strong>
                        @endif
                        <br><br>
                        <strong>Tarikh Permohonan :
                            {{ \Carbon\Carbon::parse($permohonan->created_at)->format('d/m/Y') }}</strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @if (count($pengesah)>0)
    <div class="break">
        @foreach ($pengesah as $psh)
            <table class="table table-bordered table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th colspan="2" class="text-left">PENGESAHAN KETUA BAHAGIAN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-left" style="width: 30%"><strong>Nama Ketua Bahagian</strong> </td>
                        <td class="text-left"><strong>{{ $psh->nama }}</strong> </td>
                    </tr>
                    <tr>
                        <td class="text-left" style="width: 30%"><strong>Jawatan/Gred</strong> </td>
                        <td class="text-left"><strong>{{ $psh->jawatan_pengesah }}
                                ({{ $psh->gred_pengesah }})</strong></td>
                    </tr>
                    <tr>
                        <td class="text-left" style="width: 30%"><strong>Jabatan</strong> </td>
                        <td class="text-left"><strong>{{ $psh->nama_jabatan }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-left" style="width: 30%"><strong>Ulasan</strong> </td>
                        <td class="text-left">
                            <strong>{{ $psh->ulasan }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left" style="width: 30%"><strong>Tarikh</strong> </td>
                        <td class="text-left">
                            <strong>{{ date('d/m/Y', strtotime($psh->tarikhsah)) }}</strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        @endforeach
        <br>
    </div>
    @endif
    <br>
    <div class="text-center">
        <p style="font-size: 11pt">
            <i> Borang ini adalah janaan komputer dan tidak memerlukan tandatangan.</i>
        </p>
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
