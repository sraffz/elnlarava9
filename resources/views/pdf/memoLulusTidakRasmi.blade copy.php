<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>saca</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('adminlte/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('adminlte/bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/skins/_all-skins.min.css')}}">
</head>
<style>
    .page{
        font-size: 12pt;
        font-family: Arial;
        padding-left:40px; 
        padding-right:40px;
    }
</style>

    {{-- format surat --}}
    <div class="page">
        <div class="container" >
            <div class="row" >
            	<div class="col-xl-12">
                    <div class="row">
                        <div class="col-xl-12">
                        	<br>
                        	<br>
                        	<br>
                        	 &nbsp; &nbsp; &nbsp; &nbsp;<img src="{{ asset('adminlte/dist/img/kelantan.png')}}" width="200" height="150" alt="User Image"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                        	<img src="{{ asset('img/logoeksa1.png')}}" width="130" height="130" alt="User Image"><br>
                        	
                        </div>                       
                    </div>
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-xl-12" align="center" style="font-family: Arial;font-size: 12pt;">
                        	<strong>PEJABAT SETIAUSAHA KERAJAAN NEGERI KELANTAN<br>
                                  (BAHAGIAN PENGURUSAN SUMBER MANUSIA)<br>
                                  KOTA BHARU<br><br>

                                  MEMO<br>
                                  </strong>
                          
                        </div>                       
                    </div>
					
                    <div class="row">
                        <div class="col-xl-12" >
                                <div align="justify">
									
								  _________________________________________________________________________________ 
								  <br><strong>
                                  KEPADA    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:  </strong>Ketua Jabatan<br>
                                  
                                  _________________________________________________________________________________
                                  <br><strong>
                                  DARIPADA  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </strong>Penolong Pengarah (Perkhidmatan)<br>
                                  
                                  _________________________________________________________________________________
                                  <br><strong>
                                  TARIKH    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </strong>{{ \Carbon\Carbon::parse($permohon->tarikhLulusan)->format('d/m/Y')}}<br>
                                  
                                  _________________________________________________________________________________
								  <br><strong>
                                  RUJUKAN  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </strong>SUK.D.200 (06) 455/16 ELN.JLD.{{ $permohon->no_ruj_file }} ({{ $permohon->no_ruj_bil }})<br>
                                  <strong>
                                  _________________________________________________________________________________</strong>
                                  <br>
                                  <br>

                                 <strong>
								  PERMOHONAN KEBENARAN KE LUAR NEGARA BAGI URUSAN PERSENDIRIAN PADA {{ \Carbon\Carbon::parse($permohon->tarikhMulaPerjalanan)->format('d/m/Y')}} HINGGA {{ \Carbon\Carbon::parse($permohon->tarikhAkhirPerjalanan)->format('d/m/Y')}} DI {{ strtoupper($permohon->negara) }}.</strong>
								  <br>	
								  <br>	
                                  <strong>
                                  NAMA    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ strtoupper($permohon->user->nama) }}<br>
                                  NO. K/P &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $permohon->user->nokp }}<br>
                                  JAWATAN / GRED &nbsp;: {{ strtoupper($permohon->namaJawatan) }} / {{ $permohon->user->userGredKod->gred_kod_abjad }}{{ $permohon->user->userGredAngka->gred_angka_nombor }}<br> <br>
                                  </strong>

                                  Adalah saya dengan segala hormatnya diarah merujuk kepada perkara di atas.<br><br>
                                  <div style="line-height: 1.0;">
                                  2.    Dimaklumkan bahawa permohonan  bagi  {{ strtoupper($permohon->user->nama) }} untuk ke luar negara iaitu ke {{ strtoupper($permohon->negara) }} bagi menghadiri urusan persendirian pada {{ \Carbon\Carbon::parse($permohon->tarikhMulaPerjalanan)->format('d/m/Y')}} hingga {{ \Carbon\Carbon::parse($permohon->tarikhAkhirPerjalanan)->format('d/m/Y')}} adalah <strong>telah diluluskan.</strong></div><br>

                                  Sekian dimaklumkan, terima kasih.<br><br><br>
                                     
                                  {{-- <strong> " {{ $cogan->maklumat1 }} "</strong><br><br> --}}

                                  {{-- Saya yang menjalankan amanah,<br><br><br><br> --}}



                                  <strong>( {{ $pp->maklumat1 }} )</strong>

                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12" align="center" style="font-family: Arial;font-size: 11pt;"><br><br>
                        	<strong>"SURAT INI JANAAN KOMPUTER DAN TIDAK MEMERLUKAN TANDATANGAN"</strong><br>
                          
                        </div>                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end format surat --}}


<!-- jQuery 3 -->
<script src="{{ asset('adminlte/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{ asset('adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{ asset('adminlte/bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminlte/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('adminlte/dist/js/demo.js')}}"></script>

</body>
</html>

                               