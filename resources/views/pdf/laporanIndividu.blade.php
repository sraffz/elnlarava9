<!DOCTYPE html>
<html lang="en">
<head>
  <title>Laporan</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}
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
<body>

<div class="container">

  <p align="center"><img src="{{ asset('adminlte/dist/img/kelantan.png')}}" width="200" height="150" alt="User Image" align="center"><br></p>            
  <p align="center"><strong>LAPORAN INDIVIDU PERJALANAN PEGAWAI AWAM KE LUAR NEGARA</strong></p>       <br>     
  <table class="table">
  
    <tbody>
      <tr>
        <td class="text-right" colspan="2">NAMA :</td>
        <td class="text-left">{{ $infoUser->nama }}</td>
      </tr>
      <tr>
        <td class="text-right" colspan="2">NO KAD PENGENALAN :</td>
        <td class="text-left">{{ $infoUser->nokp }}</td>
      </tr>
      <tr>
        <td class="text-right" colspan="2">EMAIL :</td>
        <td class="text-left">{{ $infoUser->email }}</td>
      </tr>
      <tr>
        <td class="text-right" colspan="2">JAWATAN :</td>
        <td class="text-left">{{ $infoUser->userJawatan->namaJawatan }}</td>
      </tr>
      <tr>
        <td class="text-right" colspan="2">GRED :</td>
        <td class="text-left">{{ $infoUser->gredKod }}{{ $infoUser->gredAngka }}</td>
      </tr>
      <tr>
        <td class="text-right" colspan="2">JANTINA :</td>
        <td class="text-left">{{ $infoUser->jantina }}</td>
      </tr>
      <tr>
        <td class="text-right" colspan="2">JABATAN :</td>
        <td class="text-left">{{ $infoUser->userJabatan->nama_jabatan }} ({{ $infoUser->userJabatan->kod_jabatan }})</td>
      </tr>
    </tbody>

    
      @foreach ($infoUser->permohonan as $element)
        @if ($element->statusPermohonan == 'Permohonan Berjaya' )
             <tr class="text-center">
                <td>{{ $element->negara }}</td>
                <td>{{ $element->tarikhMulaPerjalanan }}</td>
                <td>{{ $element->tarikhAkhirPerjalanan }}</td>
                <td>{{ $element->JenisPermohonan }}</td>
              </tr>
        @endif
      @endforeach  
      

  </table>
</div>


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
