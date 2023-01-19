<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Surat Kelulusan Rasmi</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Theme style -->
    {{-- <link rel="stylesheet" href="{{ asset('adminlte-3/dist/css/adminlte.min.css') }}"> --}}
    <style>
        /** 
            * Set the margins of the PDF to 0
            * so the background image will cover the entire page.
            **/
        @page {
            margin: 0cm 0cm;
        }

        /**
            * Define the real margins of the content of your PDF
            * Here you will fix the margins of the header and footer
            * Of your background image.
            **/
        body {
            margin-top: 4cm;
            margin-bottom: 1cm;
            margin-left: 2cm;
            margin-right: 2cm;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 15px;
        }

        /** 
            * Define the width, height, margins and position of the watermark.
            **/
        #watermark {
            position: fixed;
            bottom: 0px;
            left: 0px;
            /** The width and height may change 
                    according to the dimensions of your letterhead
                **/
            width: 21.8cm;
            height: 29cm;

            /** Your watermark should be behind every content**/
            z-index: -1000;
        }

    </style>
</head>

<body>
    {{-- format surat --}}
    <div id="watermark">
        <img src="{{ asset('adminlte-3/img/letterhead.jpg') }}" height="100%" width="96%" />
    </div>
    <div class="page">
        <div class="container">
            <div class="col-md-12">
                <div class="row"><br>
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td class="text-right" style="width: 53%">Ruj Kami&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>
                            <td style="width: 1%">:</td>
                            <td>
                                SUK.D.200 (06) 455/16 ELN.Jld @if ($ketua->jilid > 1)jld.{{ $ketua->jilid }}@endif 
                                ({{ $ketua->no_surat }})
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-right">Tarikh</td>
                            <td>:</td>
                            <td>
                                {{-- @php
                                    setlocale(LC_TIME, config('app.locale'));
                                    use Carbon\Carbon;
                                    $tarikh = Carbon::parse($permohon->tarikhLulusan)->formatLocalized('%d %B %Y');
                                @endphp
                                {{ $tarikh }} --}}
                                @php
                                        const monthNames = ["Januari", "Februari", "Mac", "April", "Mei", "Jun",
                                                "Julai", "Ogos", "September", "October", "November", "Disember"
                                                ];

                                        setlocale(LC_TIME, config('app.locale'));
                                        use Carbon\Carbon;

                                        $bulan = monthNames[Carbon::parse($permohon->tarikhLulusan)->month - 1];
                                        $tahun = Carbon::parse($permohon->tarikhLulusan)->year;
                                        $hari = Carbon::parse($permohon->tarikhLulusan)->day;
                                        
                                        // $tarikh = Carbon::parse($kelulusan->tarikh_kelulusan)->formatLocalized('%d %B %Y');
                                    @endphp
                                    {{ $hari }} {{ $bulan }} {{ $tahun }}
                            </td>
                        </tr>
                    </table>
                </div><br>
                Ke majlis, <br><br>
                {{ $ketua->jawatan_ketua }} <br>
                {{ $ketua->nama_jabatan }} <br>
                {{ $ketua->alamat }}, <br>
                {{ $ketua->poskod }} {{ $ketua->daerah }}, <br>
                {{ $ketua->negeri }} <br>
                <div class="row">
                    <div class="col-md-12">
                        {{-- <p> @if ($surat->gelaran == 10 || $surat->gelaran == 11) @else {{ getGelaran($surat->gelaran) }} @endif {{ getPangkat($surat->pangkat) }} </p> --}}
                        <p>YB.Dato'/ YBhg. Dato'/ YM Tengku/ Tuan / Puan,</p>
                    </div>
                </div>
                @php
                    $bulanMula = monthNames[Carbon::parse($permohon->tarikhMulaPerjalanan)->month - 1];
                    $tahunMula = Carbon::parse($permohon->tarikhMulaPerjalanan)->year;
                    $hariMula = Carbon::parse($permohon->tarikhMulaPerjalanan)->day;

                    $bulanAkhir = monthNames[Carbon::parse($permohon->tarikhAkhirPerjalanan)->month - 1];
                    $tahunAkhir = Carbon::parse($permohon->tarikhAkhirPerjalanan)->year;
                    $hariAkhir = Carbon::parse($permohon->tarikhAkhirPerjalanan)->day;
                @endphp
                <div class="row">
                    <div class="col-md-12" style="text-transform: uppercase; text-align: justify;">
                        <strong>PERMOHONAN KEBENARAN KE LUAR NEGARA BAGI URUSAN RASMI UNTUK MENGHADIRI
                            {{ strtoupper($permohon->lainTujuan) }} PADA
                            {{ $hariMula }} {{ $bulanMula }} {{ $tahunMula }}
                            HINGGA
                            {{ $hariAkhir }} {{ $bulanAkhir }} {{ $tahunAkhir }}
                            DI
                            {{ strtoupper($permohon->negara) }}</strong>
                    </div>
                </div><br>
                <div class="row">
                    <table class="table table-borderless table-sm">
                        <tbody style="font-weight: bold">
                            <tr>
                                <td scope="row">NAMA</td>
                                <td>:</td>
                                <td>{{ strtoupper($permohon->user->nama) }}</td>
                            </tr>
                            <tr>
                                <td scope="row">NO. K/P</td>
                                <td>:</td>
                                <td>{{ $permohon->user->nokp }}</td>
                            </tr>
                            <tr>
                                <td scope="row">JAWATAN / GRED</td>
                                <td>:</td>
                                <td>{{ strtoupper($permohon->namaJawatan) }}
                                    ({{ $permohon->user->userGredKod->gred_kod_abjad }}{{ $permohon->user->userGredAngka->gred_angka_nombor }})
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div><br>
               
                <div class="row">
                    <div align="justify">
                        {{-- <strong>
                                    NAMA
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                                    {{ strtoupper($permohon->user->nama) }}<br>
                                    NO. K/P
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                                    {{ $permohon->user->nokp }}<br>
                                    JAWATAN / GRED &nbsp;: {{ strtoupper($permohon->namaJawatan) }}
                                    ({{ $permohon->user->userGredKod->gred_kod_abjad }}{{ $permohon->user->userGredAngka->gred_angka_nombor }})<br>
                                    <br>
                                </strong> --}}

                        Adalah saya dengan segala hormatnya diarah merujuk kepada perkara di atas.<br><br>
                        <div style="line-height: 1.2;">
                            2. Sukacita dimaklumkan bahawa permohonan bagi
                            <strong>{{ strtoupper($permohon->user->nama) }}</strong> untuk ke luar negara
                            iaitu ke <strong>{{ strtoupper($permohon->negara) }}</strong> bagi menghadiri
                            urusan rasmi tersebut pada
                            <strong>{{ $hariMula }} {{ $bulanMula }} {{ $tahunMula }}
                                hingga
                                {{ $hariAkhir }} {{ $bulanAkhir }} {{ $tahunAkhir }}</strong>
                            adalah
                            @if ($permohon->statusPermohonan == 'Permohonan Berjaya')
                                <strong>telah diluluskan.</strong>
                            @else
                                <strong>tidak dapat dipertimbangkan.</strong>
                            @endif
                        </div> <br>

                        Sekian, terima kasih.<br> <br>

                        <strong> "{{ $cogan->maklumat1 }}"</strong><br>
                        @if ($cogan->maklumat2 != null)
                            <strong> "{{ $cogan->maklumat2 }}"</strong><br>
                        @endif
                        @if ($cogan->maklumat3 != null)
                            <strong> "{{ $cogan->maklumat3 }}"</strong><br>
                        @endif
                        <br>
                        Saya yang menjalankan amanah,<br>
                        <br>
                        <br>
                        <strong>({{ $pp->maklumat1 }})</strong><br>
                        {{ $pp->maklumat2 }}<br>
                        <strong>{{ $pp->maklumat3 }}</strong><br>
                        <strong>{{ $pp->maklumat4 }}</strong><br>
                    </div>
                    <br>
                    <br>
                    <div>
                        <p style="font-size: 11pt" align="center">
                            Surat ini adalah cetakan komputer dan tidak memerlukan tandatangan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
