<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MEMO TIDAK RASMI ELN</title>


    <style>
        /** 
            * Set the margins of the PDF to 0
            * so the background image will cover the entire page.
            **/
        @page {
            margin: 0cm 0cm;
        }

        hr.solid {
            border-top: 1px solid rgb(0, 0, 0);
        }

        /**
            * Define the real margins of the content of your PDF
            * Here you will fix the margins of the header and footer
            * Of your background image.
            **/
        body {
            margin-top: 1cm;
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
    <div class="page">
        <div class="">
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-xl-12" align="center">
                            <img src="{{ asset('adminlte/dist/img/kelantan.png') }}" width="27%" height="13%">
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-xl-12" align="center">
                            <strong>PEJABAT SETIAUSAHA KERAJAAN KELANTAN<br>
                                (BAHAGIAN PENGURUSAN SUMBER MANUSIA)<br>
                                <br>
                                <font style="font-size: 16pt">
                                    MEMO
                                </font>
                                <br> <br>
                            </strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div align="justify">
                                <strong>
                                    <hr class="solid">
                                    KEPADA &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $ketua->jawatan_ketua }}
                                    <br>
                                    <hr class="solid">
                                    DARIPADA &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $pp->maklumat2 }} <br>
                                    <hr class="solid">
                                    BERTARIKH &nbsp;&nbsp;&nbsp;:
                                    @php
                                        const monthNames = ["Januari", "Februari", "Mac", "April", "Mei", "Jun",
                                                "Julai", "Ogos", "September", "October", "November", "Disember"
                                                ];

                                        // setlocale(LC_TIME, config('app.locale'));
                                        use Carbon\Carbon;

                                        $bulan = monthNames[Carbon::parse($permohon->tarikhLulusan)->month - 1];
                                        $tahun = Carbon::parse($permohon->tarikhLulusan)->year;
                                        $hari = Carbon::parse($permohon->tarikhLulusan)->day;
                                        
                                        // $tarikh = Carbon::parse($kelulusan->tarikh_kelulusan)->formatLocalized('%d %B %Y');
                                    @endphp
                                    {{ $hari }} {{ $bulan }} {{ $tahun }}<br>
                                    <hr class="solid">
                                    RUJ. FAIL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: SUK.D.200 (06) 455/16
                                    ELN
                                    @if ($ketua->jilid > 1)
                                    .JLD.{{ $ketua->jilid }} 
                                    @endif
                                     ({{ $ketua->no_surat }})<br>
                                    <hr class="solid">
                                </strong> <br>
                                @php
                                        $bulanMula = monthNames[Carbon::parse($permohon->tarikhMulaPerjalanan)->month - 1];
                                        $tahunMula = Carbon::parse($permohon->tarikhMulaPerjalanan)->year;
                                        $hariMula = Carbon::parse($permohon->tarikhMulaPerjalanan)->day;

                                        $bulanAkhir = monthNames[Carbon::parse($permohon->tarikhAkhirPerjalanan)->month - 1];
                                        $tahunAkhir = Carbon::parse($permohon->tarikhAkhirPerjalanan)->year;
                                        $hariAkhir = Carbon::parse($permohon->tarikhAkhirPerjalanan)->day;

                                        if($permohon->negara_lebih_dari_satu == '1'){
                                        $negara_tambahan = ', '.strtoupper($permohon->negara_tambahan);
                                    }else {
                                        $negara_tambahan = '';
                                    }
                                @endphp
                                <strong>
                                    <font style="text-transform: uppercase">
                                        PERMOHONAN KEBENARAN KE LUAR NEGARA BAGI URUSAN PERSENDIRIAN PADA
                                        {{ $hariMula }} {{ $bulanMula }} {{ $tahunMula }}
                                        HINGGA
                                        {{ $hariAkhir }} {{ $bulanAkhir }} {{ $tahunAkhir }}
                                        DI {{ strtoupper($permohon->negara) }}{{ $negara_tambahan }}
                                    </font>
                                </strong>
                                <br>
                                <br>
                                <strong>
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
                                </strong>
                                <br>
                                Adalah saya dengan segala hormatnya diarah merujuk kepada perkara di atas.<br><br>
                                <div style="line-height: 1.0;">
                                    2. Dimaklumkan bahawa permohonan bagi
                                    <strong>{{ strtoupper($permohon->user->nama) }}</strong>
                                    untuk ke luar negara iaitu ke
                                    <strong>{{ strtoupper($permohon->negara) }}{{ $negara_tambahan }}</strong> bagi
                                    menghadiri urusan persendirian <strong>pada
                                        {{ $hariMula }} {{ $bulanMula }} {{ $tahunMula }}
                                        hingga
                                        {{ $hariAkhir }} {{ $bulanAkhir }} {{ $tahunAkhir }}</strong>
                                    adalah
                                    @if ($permohon->statusPermohonan == 'Permohonan Berjaya')
                                        <strong>telah diluluskan.</strong>
                                    @else
                                        <strong>tidak dapat dipertimbangkan.</strong>
                                    @endif
                                </div><br>

                                Sekian dimaklumkan, terima kasih.<br><br><br><br>
                                {{-- <strong> " {{ $cogan->maklumat1 }} "</strong><br><br> --}}
                                {{-- Saya yang menjalankan amanah,<br><br><br><br> --}}
                                <strong>({{ $pp->maklumat1 }})</strong>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12" align="center">
                            <br><br>
                            <br>
                            <p style="font-size: 11pt" align="center">
                                Surat ini adalah cetakan komputer dan tidak memerlukan tandatangan.
                            </p><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- end format surat --}}
</body>

</html>
