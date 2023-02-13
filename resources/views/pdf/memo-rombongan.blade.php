<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MEMO ROMBONGAN</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    {{-- <link rel="stylesheet" href="{{ asset('adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('adminlte/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/skins/_all-skins.min.css') }}"> --}}
</head>
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

    .break {
        page-break-before: always;
    }

    #table td,
    #table th {
        border: 1px solid rgb(54, 54, 54);
        padding: 5px;
        font-size: 12px;
    }

    #thead-dark {
        background: rgb(41, 41, 41);
        color: rgb(255, 255, 255);
    }

    table {
        border-collapse: collapse;
    }

</style>
{{-- <style>
    /* .page {
    } */
    .body {
        font-size: 12pt;
        /* font-family: Arial; */
        padding-left: 40px;
        padding-right: 40px;
        font-family: Arial, Helvetica, sans-serif;
        background-image: url( asset('adminlte/dist/img/kelantan.png'));

    }
</style> --}}

<body>
    <div class="page">
        <div class="container">
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
                                    KEPADA &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $kelulusan->jawatan_ketua }} <br>
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

                                        $bulan = monthNames[Carbon::parse($kelulusan->tarikh_kelulusan)->month - 1];
                                        $tahun = Carbon::parse($kelulusan->tarikh_kelulusan)->year;
                                        $hari = Carbon::parse($kelulusan->tarikh_kelulusan)->day;
                                        
                                        // $tarikh = Carbon::parse($kelulusan->tarikh_kelulusan)->formatLocalized('%d %B %Y');
                                    @endphp
                                    {{ $hari }} {{ $bulan }} {{ $tahun }}
                                    <br>

                                    <hr class="solid">
                                    RUJ. FAIL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: SUK.D.200 (06) 455/16
                                    ELN.JLD.{{ $kelulusan->jld_surat_rombongan }} ({{ $kelulusan->no_surat_rombongan }})<br>
                                    <hr class="solid">
                                </strong> <br>
                                @php
                                    $bulanMula = monthNames[Carbon::parse($permohon->tarikhMulaRom)->month - 1];
                                    $tahunMula = Carbon::parse($permohon->tarikhMulaRom)->year;
                                    $hariMula = Carbon::parse($permohon->tarikhMulaRom)->day;
            
                                    $bulanAkhir = monthNames[Carbon::parse($permohon->tarikhAkhirRom)->month - 1];
                                    $tahunAkhir = Carbon::parse($permohon->tarikhAkhirRom)->year;
                                    $hariAkhir = Carbon::parse($permohon->tarikhAkhirRom)->day;
                                @endphp
                                <font style="text-transform: uppercase">
                                    <strong>PERMOHONAN KEBENARAN KE LUAR NEGARA Secara rombongan bagi tujuan
                                        {{ $permohon->tujuanRom }}
                                        {{ strtoupper($permohon->lainTujuan) }} PADA
                                        {{ $hariMula }} {{ $bulanMula }} {{ $tahunMula }}
                                        HINGGA
                                        {{ $hariAkhir }} {{ $bulanAkhir }} {{ $tahunAkhir }}
                                        DI
                                        {{ strtoupper($permohon->negaraRom) }}
                                    </strong>
                                </font>
                                <br>

                                <br>
                                Dengan segala hormatnya saya diarah merujuk kepada perkara di atas.<br><br>
                                <div style="line-height: 1.0;">
                                    2.

                                    @if ($permohon->statusPermohonanRom == 'Permohonan Berjaya')
                                        Sukacita
                                    @elseif ($permohon->statusPermohonanRom == 'Permohonan Gagal')
                                        Dukacita
                                    @endif

                                    dimaklumkan bahawa permohonan tuan bagi <strong>{{ $bilpeserta }}
                                        orang</strong> pegawai sebagaimana senarai di lampiran untuk ke luar
                                    negara iaitu ke <strong>{{ strtoupper($permohon->negaraRom) }}</strong> bagi
                                    tujuan {{ $permohon->tujuanRom }}
                                    <strong>pada
                                        {{ $hariMula }} {{ $bulanMula }} {{ $tahunMula }}
                                        hingga
                                        {{ $hariAkhir }} {{ $bulanAkhir }} {{ $tahunAkhir }}</strong>

                                    @if ($permohon->statusPermohonanRom == 'Permohonan Berjaya')
                                        telah <strong>diluluskan.</strong>
                                    @elseif ($permohon->statusPermohonanRom == 'Permohonan Gagal')
                                        adalah <strong>tidak dapat dipertimbangkan.</strong>
                                    @endif
                                </div><br>

                                Sekian dimaklumkan, terima kasih.<br><br>
                                <br>
                                <br>
                                <strong>( {{ $pp->maklumat1 }})</strong>
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
            <div class="break">
                <div style="text-align: center; text-transform:uppercase;">
                    <h3>SENARAI PEGAWAI DAN KAKITANGAN MENYERTAI ROMBONGAN KE {{ $permohon->negaraRom }} pada
                        {{ $hariMula }} {{ $bulanMula }} {{ $tahunMula }}
                        hingga
                        {{ $hariAkhir }} {{ $bulanAkhir }} {{ $tahunAkhir }}</strong>
                    </h3>
                </div>
                <table id="table" class="table" style="width: 100%;">
                    <thead style="text-align: center" id="thead-dark">
                        <tr>
                            <th><strong>BIL</strong> </th>
                            <th><strong>NAMA</strong> </th>
                            <th><strong>NO. KP</strong> </th>
                            <th><strong>JAWATAN & GRED</strong> </th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- <tr>
                            <td style="text-align: center"><strong>1</strong></td>
                            <td class="text-left"><strong>{{ $permohon->nama }} <br> (Ketua Rombongan)</strong></td>
                            <td style="text-align: center"><strong>{{ $permohon->nokp }}</strong></td>
                            <td><strong>{{ $permohon->namaJawatan }}
                                    ({{ $permohon->gred_kod_abjad }}{{ $permohon->gred_angka_nombor }})</strong>
                            </td>
                        </tr> --}}
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($allPermohonan as $index => $element)
                            @if ($element->rombongans_id == $permohon->rombongans_id)
                                <tr>
                                    <td style="text-align: center"><strong> {{ $i++ }}</strong></td>
                                    <td class="text-left">
                                        <strong>
                                            {{ $element->nama }} <br>
                                            @if ($permohon->ketua_rombongan == $element->usersID)
                                                (Ketua Rombongan)
                                            @endif
                                        </strong>
                                    </td>
                                    <td style="text-align: center"><strong> {{ $element->nokp }}</strong></td>
                                    <td><strong> {{ $element->namaJawatan }}
                                            ({{ $element->gred }})</strong>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
{{-- format surat --}}
{{-- end format surat --}}


<!-- jQuery 3 -->
{{-- <script src="{{ asset('adminlte/bower_components/jquery/dist/jquery.min.js') }}"></script>
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
